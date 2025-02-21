<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Api\V1\Services;

use App\Http\Resources\Api\V1\ServiceResource;
use App\Models\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class IndexController
{
    public function __invoke(Request $request): JsonResponse
    {
        $services = QueryBuilder::for(Service::class)
            ->allowedIncludes(['checks'])
            ->allowedFilters(['url'])
            ->getEloquentBuilder()
            ->cursorPaginate(config('app.pagination.default'));

        return ServiceResource::collection($services)->toResponse($request);
    }
}
