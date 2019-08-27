<?php

namespace Modules\Core\Repositories;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Interfaces\EloquentRepositoryInterface;

abstract class AbstractEloquentRepository implements EloquentRepositoryInterface
{
    public $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }
}
