<?php
namespace App\Repositories;

use Illuminate\Support\Str;

class MainRepository
{
    protected $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function getAll(array $filters = [], array $fields = ['*'], $paginate = true)
    {
        $query = $this->model->newQuery();

        if (method_exists($this->model, 'scopeFilter')) {
            $query->filter($filters);
        }

        $query->select($fields);

        if ($paginate) {
            $modelTableName      = $this->model->getTable();
            $paginationParamName = Str::kebab(Str::singular($modelTableName));

            return $query->paginate(10, ['*'], $paginationParamName)->onEachSide(0);
        }

        return $query->get();
    }

    public function getById(int $id, array $fields = ['*'])
    {
        return $this->model->select($fields)->findOrFail($id);
    }
}
