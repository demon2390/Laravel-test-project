<?php

declare(strict_types = 1);

namespace App\Repositories\Services;

use App\Models\Service;
use App\Repositories\Services\Interfaces\ServiceRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ServiceRepository implements ServiceRepositoryInterface
{
    private Service $model;

    public function __construct(Service $model)
    {
        $this->model = $model;
    }

    public function getAllUserServices(): Collection
    {
        return $this->model->newQuery()->where('user_id', auth()->id())->get();
    }
}
