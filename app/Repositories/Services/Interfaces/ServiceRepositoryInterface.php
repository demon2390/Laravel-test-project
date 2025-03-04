<?php

namespace App\Repositories\Services\Interfaces;

use App\Models\Service;
use Illuminate\Contracts\Pagination\CursorPaginator;

interface ServiceRepositoryInterface
{
    /** @return CursorPaginator<int, Service> */
    public function getAllUserServices(): CursorPaginator;

    public function findService(string $id): Service;
}
