<?php

namespace App;

use Illuminate\Support\Facades\Redis;

class ModelRepository implements ModelRepositoryInterface
{
    protected $model;
    protected $cacheKey;
    protected $cacheTime;

    public function __construct($model, $cacheTime = 3600)
    {
        $this->model = $model;
        $this->cacheTime = $cacheTime;
        $this->cacheKey = strtolower(str_replace('\\', '-', $model));
    }

    public function all()
    {
        $cachedData = Redis::get($this->cacheKey);

        if (!empty($cachedData)) {
            return json_decode($cachedData);
        } else {
            $data = $this->model::all();
            Redis::set($this->cacheKey,json_encode($data->toArray()));
            Redis::expire($this->cacheKey, $this->cacheTime);

            return $data;
        }

    }

    public function find(int $id)
    {
        $key = $this->cacheKey . ':' . $id;
        $cachedData = Redis::get($key);

        if (!empty($cachedData)) {
            return json_decode($cachedData);
        } else {
            $data = $this->model::find($id);
            Redis::set($key, json_encode($data->toArray()));
            Redis::expire($key, $this->cacheTime);

            return $data;
        }
    }

    public function create(array $data)
    {
        $record = $this->model::create($data);

        Redis::del($this->cacheKey);

        return $record;
    }

    public function update($id, array $data)
    {
        $record = $this->model::find($id);
        if ($record) {
            $record->update($data);

            Redis::del($this->cacheKey);
            Redis::del($this->cacheKey . ':' . $id);

            return $record;
        }
        return false;
    }

    public function delete($id)
    {
        $record = $this->model::find($id);
        if ($record) {
            $record->delete();

            Redis::del($this->cacheKey);
            Redis::del($this->cacheKey . ':' . $id);

            return true;
        }
        return false;
    }
}
