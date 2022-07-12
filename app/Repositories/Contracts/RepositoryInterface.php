<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Model;

interface RepositoryInterface
{
    public function all(array $columns = [],array $relations = []);

    public function find(int $ID, array $columns = null);

    public function findOrFail(int $ID, array $columns = null);

    public function findBy(array $criteria, array $columns = null, array $relations = [], bool $single = true);

    public function store(array $items);

    public function storeMany(array $items);

    public function update(int $ID, array $items);

    public function updateWithinModel(Model $model, array $items);

    public function updateBy(array $criteria, array $data);

    public function delete(int $ID);

    public function deleteBy(array $criteria);

    public function beginTransaction();

    public function commit();

    public function rollBack();
}
