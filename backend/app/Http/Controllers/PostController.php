<?php

namespace App\Http\Controllers;

use App\ModelRepository;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Info(
 *     title="ConectaHuggy API",
 *     version="1.0.0",
 *     description="API documentation for ConectaHuggy"
 * )
 *
 *  @OA\Server(
 *     url="http://localhost/api",
 *     description="Local Development Server"
 * )
 *
 * @OA\Schema(
 *     schema="Post",
 *     type="object",
 *     @OA\Property(
 *         property="id",
 *         type="integer"
 *     ),
 *     @OA\Property(
 *         property="title",
 *         type="string"
 *     ),
 *     @OA\Property(
 *         property="content",
 *         type="string"
 *     ),
 *     @OA\Property(
 *         property="user_id",
 *         type="integer"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time"
 *     )
 * )
 */

class PostController extends Controller
{
    protected $repository;

    public function __construct()
    {
        $this->repository = new ModelRepository(Post::class);
    }

    /**
     * @OA\Get(
     *     path="/posts",
     *     summary="Get list of posts",
     *     tags={"Posts"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Post"))
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="No content"
     *     )
     * )
     */
    public function index()
    {
        $posts = $this->repository->all(['comments', 'likes'], ['user']);
        if (empty($posts[0])) {
            return response()->json([], 204);
        }

        return response()->json($posts);
    }

    /**
     * @OA\Post(
     *     path="/posts",
     *     summary="Create a new post",
     *     tags={"Posts"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title","content"},
     *             @OA\Property(property="title", type="string", example="My Post Title"),
     *             @OA\Property(property="content", type="string", example="This is the content of the post.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Post created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Post")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="The given data was invalid.")
     *         )
     *     ),
     *     security={{"bearerAuth":{}}}
     * )
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
     * @OA\Get(
     *     path="/posts/{id}",
     *     summary="Get post by id",
     *     tags={"Posts"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of post to return",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Post")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Post not found"
     *     )
     * )
     */
    public function show(Post $post)
    {
        $post = $this->repository->find($post->id, ['comments', 'likes'], ['user']);
        return response()->json($post);
    }

    /**
     * @OA\Put(
     *     path="/posts/{id}",
     *     summary="Update a post",
     *     tags={"Posts"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of post to update",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title","content"},
     *             @OA\Property(property="title", type="string", example="My Post Title"),
     *             @OA\Property(property="content", type="string", example="This is the content of the post.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Post updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Post")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="The given data was invalid.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Post not found"
     *     ),
     *     security={{"bearerAuth":{}}}
     * )
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
     * @OA\Delete(
     *     path="/posts/{id}",
     *     summary="Delete a post",
     *     tags={"Posts"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of post to delete",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Post deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Post not found"
     *     ),
     *     security={{"bearerAuth":{}}}
     * )
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
