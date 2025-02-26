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
        if (! Gate::allows('viewAny', Service::class)) {
            abort(Response::HTTP_FORBIDDEN, __('v1.failure.view', ['resource' => 'services']));
        }

        $cachedServices = Cache::rememberForever(
            key: CacheKeys::USER_SERVICES->value . '_' . auth()->id(),
            callback: fn() => Service::query()
                ->where('user_id', auth()->id())
                ->get(),
        );

        if ($cachedServices->isNotEmpty()) {
            $services = QueryBuilder::for($cachedServices->toQuery())
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
        if (! Gate::allows('create', Service::class)) {
            abort(Response::HTTP_FORBIDDEN, __('v1.failure.verify', ['resource' => 'service']));
        }

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

    public function show(Request $request, string $ulid): ServiceResource|MessageResponses
    {
        $service = Cache::rememberForever(
            key: CacheKeys::SERVICE->value . '_' . $ulid,
            callback: fn() => Service::query()->findOrFail($ulid),
        );

        if (! Gate::allows('view', $service)) {
            return new MessageResponses(
                __('v1.failure.policy', ['resource' => 'service', 'action' => 'view']),
                Response::HTTP_FORBIDDEN,
            );
        }

        return new ServiceResource($service);
    }

    public function update(StoreRequest $request, Service $service): MessageResponses
    {
        if (! Gate::allows('update', $service)) {
            return new MessageResponses(
                __('v1.failure.policy', ['resource' => 'service', 'action' => 'updated']),
                Response::HTTP_FORBIDDEN,
            );
        }

        UpdateServiceJob::dispatch($request->validated(), $service);

        return new MessageResponses(
            __('v1.success.accept', ['resource' => 'service', 'action' => 'updated']),
            Response::HTTP_ACCEPTED,
        );
    }

    public function delete(Request $request, Service $service): MessageResponses
    {
        if (! Gate::allows('delete', $service)) {
            return new MessageResponses(
                __('v1.failure.policy', ['resource' => 'service', 'action' => 'delete']),
                Response::HTTP_FORBIDDEN,
            );
        }

        DeleteServiceJob::dispatch($service);

        return new MessageResponses(
            __('v1.success.accept', ['resource' => 'service', 'action' => 'deleted']),
            Response::HTTP_ACCEPTED,
        );
    }
}
