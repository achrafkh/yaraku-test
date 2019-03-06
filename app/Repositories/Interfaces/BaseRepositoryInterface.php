<?php

namespace App\Repositories\Interfaces;

interface BaseRepositoryInterface
{
    public function all();
    public function query();
    public function create(array $attributes);
    public function update(int $id, array $attributes);
    public function find(int $id);
    public function delete(int $id);
}
