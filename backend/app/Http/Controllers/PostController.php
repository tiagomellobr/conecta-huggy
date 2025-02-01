<?php

namespace App\Http\Controllers;

use App\ModelRepository;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    protected $repository;

    public function __construct()
    {
        $this->repository = new ModelRepository(Post::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = $this->repository->all(['comments', 'likes']);
        if (empty($posts[0])) {
            return response()->json([], 204);
        }

        return response()->json($posts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response($validator->errors()->toJson(), 400);
        }

        $post = $validator->validated();
        $post['user_id'] = Auth::user()->id;

        $post = $this->repository->create($post);

        $cacheKey = strtolower(str_replace('\\', '-', Post::class));
        Redis::del($cacheKey);

        return response()->json($post, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $post = $this->repository->find($post->id, ['comments', 'likes']);
        return response()->json($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response($validator->errors()->toJson(), 400);
        }

        /** @var User $user */
        if (Auth::user()->id !== $post->user_id) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $post = $this->repository->update($post->id, $validator->validated());

        $cacheKey = strtolower(str_replace('\\', '-', Post::class));
        $cacheKeyPost = $cacheKey . '-' . $post->id;
        Redis::del($cacheKey);
        Redis::del($cacheKeyPost);

        return response()->json($post);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        if (Auth::user()->id !== $post->user_id) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $this->repository->delete($post->id);

        $cacheKey = strtolower(str_replace('\\', '-', Post::class));
        $cacheKeyPost = $cacheKey . '-' . $post->id;
        Redis::del($cacheKey);
        Redis::del($cacheKeyPost);

        return response()->json(null, 204);
    }
}
