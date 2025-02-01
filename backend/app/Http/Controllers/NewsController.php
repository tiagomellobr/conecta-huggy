<?php

namespace App\Http\Controllers;

use App\ModelRepository;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;

class NewsController extends Controller
{
    protected $repository;

    public function __construct()
    {
        $this->repository = new ModelRepository(News::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $news = $this->repository->all();
        if (empty($news[0])) {
            return response()->json([], 204);
        }

        return response()->json($news);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $news = $this->repository->create($request->all());

        $cacheKey = strtolower(str_replace('\\', '-', News::class));
        Redis::del($cacheKey);

        return response()->json($news, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(News $news)
    {
        $news = $this->repository->find($news->id);

        return response()->json($news);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, News $news)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $news = $this->repository->update($news->id, $request->all());

        $cacheKey = strtolower(str_replace('\\', '-', News::class));
        $cacheKeyPost = $cacheKey . '-' . $news->id;
        Redis::del($cacheKey);
        Redis::del($cacheKeyPost);

        return response()->json($news);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(News $news)
    {
        $this->repository->delete($news->id);

        $cacheKey = strtolower(str_replace('\\', '-', News::class));
        $cacheKeyPost = $cacheKey . '-' . $news->id;
        Redis::del($cacheKey);
        Redis::del($cacheKeyPost);

        return response()->json(null, 204);
    }
}
