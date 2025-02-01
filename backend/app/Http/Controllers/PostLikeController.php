<?php

namespace App\Http\Controllers;

use App\ModelRepository;
use App\Models\Post;
use App\Models\PostLike;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class PostLikeController extends Controller
{
    protected $repository;

    public function __construct()
    {
        $this->repository = new ModelRepository(PostLike::class);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Post $post)
    {
        $like = PostLike::where([
            'post_id' => $post->id,
            'user_id' => Auth::user()->id,
        ])->first();

        if (!empty($like)) {
            return response()->json(['message' => 'Already liked'], 400);
        }

        $like = $this->repository->create([
            'post_id' => $post->id,
            'user_id' => Auth::user()->id,
        ]);

        $cacheKey = strtolower(str_replace('\\', '-', Post::class));
        Redis::del($cacheKey);


        return response()->json($like, 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post, int $like)
    {
        $like = PostLike::where([
            'post_id' => $post->id,
            'user_id' => Auth::user()->id,
        ])->first();

        if (empty($like)) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $this->repository->delete($like->id);

        $cacheKey = strtolower(str_replace('\\', '-', Post::class));
        Redis::del($cacheKey);

        return response()->json(null, 204);
    }

}
