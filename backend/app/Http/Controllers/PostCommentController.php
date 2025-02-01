<?php

namespace App\Http\Controllers;

use App\ModelRepository;
use App\Models\Post;
use App\Models\PostComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;

class PostCommentController extends Controller
{
    protected $repository;

    public function __construct()
    {
        $this->repository = new ModelRepository(PostComment::class);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Post $post)
    {
        $comments = $this->repository->findBy(['post_id' => $post->id]);
        return response()->json($comments);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Post $post)
    {
        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'content' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response($validator->errors()->toJson(), 400);
        }

        $comment = $validator->validated();
        $comment['post_id'] = $post->id;
        $comment['user_id'] = Auth::user()->id;

        $comment = $this->repository->create($comment);

        $cacheKey = strtolower(str_replace('\\', '-', PostComment::class) . '-' . $post->id);
        Redis::del($cacheKey);

        return response()->json($comment, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post, int $id)
    {
        $comment = $this->repository->findBy(['post_id' => $post->id, 'id' => $id]);

        if (empty($comment[0])) {
            return response()->json(['message' => 'Comment not found'], 404);
        }

        return response()->json($comment[0]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post, int $id)
    {
        $validator = Validator::make($request->all(), [
            'content' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response($validator->errors()->toJson(), 400);
        }

        $comment = $validator->validated();

        $comment = $this->repository->update($id, $comment);

        if (!$comment) {
            return response()->json(['message' => 'Comment not found'], 404);
        }

        $cacheKey = strtolower(str_replace('\\', '-', PostComment::class) . '-' . $post->id);
        $cacheKeyComment = $cacheKey . '-' . $id;
        Redis::del($cacheKey);
        Redis::del($cacheKeyComment);

        return response()->json($comment, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post, int $id)
    {
        $comment = $this->repository->findBy(['post_id' => $post->id, 'id' => $id]);
        if (empty($comment[0])) {
            return response()->json(['message' => 'Comment not found'], 404);
        }

        if (Auth::user()->id !== $comment[0]->user_id) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $this->repository->delete($id);

        $cacheKey = strtolower(str_replace('\\', '-', PostComment::class) . '-' . $post->id);
        $cacheKeyComment = $cacheKey . '-' . $id;
        Redis::del($cacheKey);
        Redis::del($cacheKeyComment);

        return response()->json(['message' => 'Comment deleted'], 200);
    }
}
