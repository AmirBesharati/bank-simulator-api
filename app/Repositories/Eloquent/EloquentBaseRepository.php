<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EloquentBaseRepository implements RepositoryInterface
{
    protected $model;

    public function all(array $columns = null, array $relations = [], string $groupBy = null)
    {
        $query = $this->model::query();
        if (!empty($relations)) {
            $query->with($relations);
        }

        if (!is_null($columns)) {
            return $query->get($columns);
        }

        return $query->get();
    }

    public function find(int $ID, array $columns = null, array $relations = [])
    {
        $query = $this->model::query();

        if (!is_null($columns)) {
            $query->select($columns);
        }

        if (!empty($relations)) {
            $query->with($relations);
        }

        return $query->find($ID);
    }

    public function findOrFail(int $ID, array $columns = null, array $relations = [])
    {
        $query = $this->model::query();

        if (!is_null($columns)) {
            $query->select($columns);
        }

        if (!empty($relations)) {
            $query->with($relations);
        }

        return $query->findOrFail($ID);
    }

    public function store(array $items)
    {
        return $this->model::create($items);
    }

    public function update(int $ID, array $items)
    {
        $object = $this->find($ID);

        if ($object) {
            return $object->update($items);
        }

        return null;
    }

    public function updateWithinModel(Model $model, array $item): bool
    {
        return $model->update($item);
    }

    public function delete(int $ID)
    {
        if (intval($ID) > 0) {
            return $this->model::destroy($ID);
        }

        return null;
    }

    public function findBy(array $criteria, array $columns = null, array $relations = [], bool $single = true, array $orderBy = [])
    {
        $query = $this->model::query();
        foreach ($criteria as $key => $item) {
            $query->where($key, $item);
        }

        if (!empty($relations)) {
            $query->with($relations);
        }

        foreach ($orderBy as $key => $item) {
            $query->orderBy($key, $item);
        }

        $method = $single ? 'first' : 'get';

        return is_null($columns) ? $query->{$method}() : $query->{$method}($columns);
    }

    public function updateBy(array $criteria, array $data)
    {
        $query = $this->model::query();
        foreach ($criteria as $key => $value) {
            $query->where($key, $value);
        }

        return $query->update($data);
    }

    public function deleteBy(array $criteria)
    {
        $query = $this->model::query();
        foreach ($criteria as $key => $value) {
            $query->where($key, $value);
        }

        return $query->delete();
    }

    public function storeMany(array $items)
    {
        return $this->model::createMany($items);
    }

    public function beginTransaction()
    {
        DB::beginTransaction();
    }

    public function commit()
    {
        DB::commit();
    }

    public function rollBack()
    {
        DB::rollBack();
    }
}
