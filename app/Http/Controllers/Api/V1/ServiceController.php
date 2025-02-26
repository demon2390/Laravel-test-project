<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Api\V1;

use App\Enums\CacheKeys;
use App\Http\Requests\V1\Services\StoreRequest;
use App\Http\Resources\Api\V1\ServiceResource;
use App\Http\Responses\V1\MessageResponses;
use App\Jobs\Services\CreateServiceJob;
use App\Jobs\Services\DeleteServiceJob;
use App\Jobs\Services\UpdateServiceJob;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpFoundation\Response;

class ServiceController
{
    public function index(Request $request): JsonResponse
    {
        $cachedServices = Cache::rememberForever(
            key: CacheKeys::USER_SERVICES->value . '_' . auth()->id(),
            callback: fn() => Service::query()
                ->where('user_id', auth()->id())
                ->get(),
        );

        if ($cachedServices->isNotEmpty()) {
            $services = QueryBuilder::for(
                subject: $cachedServices->toQuery()
            )
                ->allowedIncludes(['checks'])
                ->allowedFilters(['url'])
                ->getEloquentBuilder()
                ->orderByDesc('created_at')
                ->cursorPaginate(config('app.pagination.default'));
        } else {
            $services = new Collection;
        }

        return ServiceResource::collection($services)->toResponse($request);
    }

    public function store(StoreRequest $request): MessageResponses
    {
        CreateServiceJob::dispatch(array_merge(
            $request->validated(),
            [
                'user_id' => auth()->id(),
            ]
        ));

        return new MessageResponses(
            __('v1.success.accept', ['resource' => 'service', 'action' => 'created']),
            Response::HTTP_ACCEPTED,
        );
    }

    public function show(Request $request, Service $service): ServiceResource
    {
        Cache::flush();

        $service = QueryBuilder::for(
            subject: Service::query()->where('id', $service->id)
        )
            ->allowedIncludes(['checks'])
            ->allowedFilters(['url'])
            ->getEloquentBuilder()
            ->first();

        return new ServiceResource($service);
    }

    public function update(StoreRequest $request, Service $service): MessageResponses
    {
        UpdateServiceJob::dispatch($request->validated(), $service);

        return new MessageResponses(
            __('v1.success.accept', ['resource' => 'service', 'action' => 'updated']),
            Response::HTTP_ACCEPTED,
        );
    }

    public function delete(Request $request, Service $service): MessageResponses
    {
        DeleteServiceJob::dispatch($service);

        return new MessageResponses(
            __('v1.success.accept', ['resource' => 'service', 'action' => 'deleted']),
            Response::HTTP_ACCEPTED,
        );
    }
}
