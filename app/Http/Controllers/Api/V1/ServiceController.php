<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\ServiceFormRequest;
use App\Http\Resources\Api\V1\ServiceResource;
use App\Http\Responses\V1\MessageResponses;
use App\Jobs\Services\CreateServiceJob;
use App\Jobs\Services\DeleteServiceJob;
use App\Jobs\Services\UpdateServiceJob;
use App\Models\Service;
use App\Repositories\Services\Interfaces\ServiceRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

final class ServiceController extends Controller
{
    public function __construct(private readonly ServiceRepositoryInterface $repository) {}

    public function index(Request $request): JsonResponse
    {
        Cache::flush();
        $services = $this->repository->getAllUserServices();

        if ($services->isEmpty()) {
            $services = new Collection();
        }

        return ServiceResource::collection($services)->toResponse($request);
    }

    public function store(ServiceFormRequest $request): MessageResponses
    {
        CreateServiceJob::dispatch($request->merge(['user_id' => Auth::id()])->toArray());

        return new MessageResponses(
            __('v1.success.accept', ['resource' => 'service', 'action' => 'created']),
            Response::HTTP_ACCEPTED,
        );
    }

    public function show(Request $request, string $service): ServiceResource
    {
        $serviceModel = $this->repository->findService($service);

        return new ServiceResource($serviceModel);
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
