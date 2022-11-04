<?php

namespace App\Services;

use App\Helpers\Traits\HasAttrs;
use Illuminate\Database\Eloquent\Model;

class BaseService
{
    use HasAttrs;

    protected Model $model;

    public function setModel(Model $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getModel(): Model
    {
        return $this->model;
    }

    public function __call($method, $arguments)
    {
        return $this->model->{$method}(...$arguments);
    }

}