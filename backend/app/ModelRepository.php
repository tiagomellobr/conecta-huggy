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

    public function all($withCount = null)
    {
        $cachedData = Redis::get($this->cacheKey);

        if (!empty($cachedData)) {
            return json_decode($cachedData);
        } else {
            if ($withCount) {
                $data = $this->model::withCount($withCount)->get();
            } else {
                $data = $this->model::all();
            }

            if (!empty($data->toArray())) {
                Redis::set($this->cacheKey,json_encode($data->toArray()));
                Redis::expire($this->cacheKey, $this->cacheTime);
            }
            return $data;
        }

    }

    public function find(int $id, $withCount = null)
    {
        $key = $this->cacheKey . '-' . $id;
        $cachedData = Redis::get($key);

        if (!empty($cachedData)) {
            return json_decode($cachedData);
        } else {
            if ($withCount) {
                $data = $this->model::withCount($withCount)->find($id);
            } else {
                $data = $this->model::find($id);
            }

            if (!empty($data->toArray())) {
                Redis::set($key, json_encode($data->toArray()));
                Redis::expire($key, $this->cacheTime);
            }

            return $data;
        }
    }

    public function create(array $data)
    {
        $record = $this->model::create($data);
        return $record;
    }

    public function update($id, array $data)
    {
        $record = $this->model::find($id);
        if ($record) {
            $record->update($data);
            return $record;
        }
        return false;
    }

    public function delete($id)
    {
        $record = $this->model::find($id);
        if ($record) {
            $record->delete();
            return true;
        }
        return false;
    }

    public function findBy()
    {
        $args = func_get_args();
        $key = $this->cacheKey . '-' . implode('-', $args[0]);
        $cachedData = Redis::get($key);

        if (!empty($cachedData)) {
            return json_decode($cachedData);
        } else {
            $data = call_user_func_array([$this->model, 'where'], $args)->get();
            if (!empty($data->toArray())) {
                Redis::set($key, json_encode($data->toArray()));
                Redis::expire($key, $this->cacheTime);
            }

            return $data;
        }
    }
}
