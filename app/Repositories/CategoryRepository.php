<?php
namespace App\Repositories;

use App\Models\Category;

class CategoryRepository extends MainRepository
{
    protected $model;

    public function __construct(Category $model)
    {
        $this->model = $model;
    }

    public function store(array $data)
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data)
    {
        return $this->model->find($id)->update($data);
    }

    public function delete(int $id)
    {
        return $this->model->find($id)->delete();
    }

    public function force_delete($id): bool
    {
        return $this->model->withTrashed()->find($id)->forceDelete();
    }

    public function restore(int $id)
    {
        $model = $this->model->withTrashed()->find($id);
        if ($model && $model->trashed()) {
            $model->restore();
        }
        return $model;
    }
}
