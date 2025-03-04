<?php

declare(strict_types=1);

namespace App\Repositories\Services;

use App\Models\Service;
use App\Repositories\Services\Interfaces\ServiceRepositoryInterface;
use Illuminate\Contracts\Pagination\CursorPaginator;
use Illuminate\Support\Facades\Auth;

final readonly class ServiceRepository implements ServiceRepositoryInterface
{
    public function __construct(private Service $model) {}

    public function getAllUserServices(): CursorPaginator
    {
        return $this->model->newQuery()
            ->where('user_id', Auth::id())
            ->cursorPaginate(20);
    }

    public function findService(string $id): Service
    {
        return $this->model->newQuery()
            ->where('user_id', Auth::id())
            ->findOrFail($id);
    }
}
