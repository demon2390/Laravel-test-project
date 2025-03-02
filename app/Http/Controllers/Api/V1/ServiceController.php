<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\ServiceFormRequest;
use App\Http\Resources\Api\V1\ServiceResource;
use App\Http\Responses\V1\MessageResponses;
use App\Jobs\Services\{CreateServiceJob, DeleteServiceJob, UpdateServiceJob};
use App\Models\Service;
use App\Repositories\Services\Interfaces\ServiceRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\{AllowedFilter, AllowedSort, QueryBuilder};
use Symfony\Component\HttpFoundation\Response;

class ServiceController extends Controller
{
    public function __construct(private readonly ServiceRepositoryInterface $repository)
    {
    }

    public function index(Request $request): JsonResponse
    {
        $cachedServices = $this->repository->getAllUserServices();

        if ($cachedServices->isNotEmpty()) {
            $services = QueryBuilder::for(
                subject: $cachedServices->toQuery()
            )
                ->allowedIncludes(['checks'])
                ->allowedFilters([
                    'url',
                    'name',
                    AllowedFilter::callback('has_checks', fn(Builder $query) => $query->whereHas(relation: 'checks', operator: '>', count: 0)),
                ])
                ->allowedSorts([
                    'name',
                    'url',
                    AllowedSort::field('created', 'created_at'),
                    AllowedSort::field('updated', 'updated_at'),
                ])
                ->defaultSort('-updated_at')
                ->getEloquentBuilder()
                ->cursorPaginate(config('app.pagination.default'));
        } else {
            $services = new Collection;
        }

        return ServiceResource::collection($services)->toResponse($request);
    }

    public function store(ServiceFormRequest $request): MessageResponses
    {
        CreateServiceJob::dispatch($request->merge(['user_id' => auth()->id()])->toArray());

        return new MessageResponses(
            __('v1.success.accept', ['resource' => 'service', 'action' => 'created']),
            Response::HTTP_ACCEPTED,
        );
    }

    public function show(Request $request, Service $service): ServiceResource
    {
        $service = QueryBuilder::for(
            subject: Service::query()->where('id', $service->id)
        )
            ->allowedIncludes(['checks'])
            ->getEloquentBuilder()
            ->first();

        return new ServiceResource($service);
    }

    public function update(ServiceFormRequest $request, Service $service): MessageResponses
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
