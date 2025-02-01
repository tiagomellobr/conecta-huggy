<?php

namespace App\Http\Controllers;

use App\ModelRepository;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;

class VideoController extends Controller
{
    protected $repository;

    public function __construct()
    {
        $this->repository = new ModelRepository(Video::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $videos = $this->repository->all();
        if (empty($videos[0])) {
            return response()->json([], 204);
        }

        return response()->json($videos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'url' => 'required|string|url',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $video = $this->repository->create($request->all());

        $cacheKey = strtolower(str_replace('\\', '-', Video::class));
        Redis::del($cacheKey);

        return response()->json($video, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Video $video)
    {
        $videos = $this->repository->find($video->id);
        return response()->json($videos);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Video $video)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'url' => 'required|string|url',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $video = $this->repository->update($video->id, $request->all());

        $cacheKey = strtolower(str_replace('\\', '-', Video::class));
        $cacheKeyPost = $cacheKey . '-' . $video->id;
        Redis::del($cacheKey);
        Redis::del($cacheKeyPost);

        return response()->json($video);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Video $video)
    {
        $this->repository->delete($video->id);

        $cacheKey = strtolower(str_replace('\\', '-', Video::class));
        $cacheKeyPost = $cacheKey . '-' . $video->id;
        Redis::del($cacheKey);
        Redis::del($cacheKeyPost);

        return response()->json(null, 204);
    }
}
