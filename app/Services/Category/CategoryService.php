<?php

namespace App\Services\Category;

use App\Interfaces\Repository\CategoryRepositoryInterface;
use App\Interfaces\Service\CategoryServiceInterface;
use App\Models\Category;
use App\Services\BaseService;

class CategoryService extends BaseService implements CategoryServiceInterface
{
    public array $response = [];

    public function __construct(Category $category)
    {
        $this->model = $category;
    }

    public function createCategory(): self
    {
        $this->model = $this->model->newQuery()->create($this->getAttrs());

        return $this;
    }

    public function updateCategory(): self
    {
        $this->model->update($this->getAttrs());

        return $this;
    }

    public function deleteCategory(): self
    {
        $this->model->delete();

        return $this;
    }

    public function getResponse(): array
    {
        return $this->response;
    }

    public function setResponse($response): self
    {
        $this->response = $response;

        return $this;
    }

    public function getSelectedCategory()
    {
        return $this->model
            ->newQuery()
            ->select('id', 'name')
            ->get();
    }
}