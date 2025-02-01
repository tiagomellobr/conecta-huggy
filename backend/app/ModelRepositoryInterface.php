<?php

namespace App;

interface ModelRepositoryInterface
{
    public function all();
    public function find(int $id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
}
