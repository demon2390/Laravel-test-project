<?php

declare(strict_types=1);

namespace App\Repositories\Services\Decorators;

use App\Enums\CacheKeys;
use App\Models\Service;
use App\Repositories\Services\Interfaces\ServiceRepositoryInterface;
use App\Repositories\Services\ServiceRepository;
use Illuminate\Contracts\Pagination\CursorPaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

final readonly class CachedServiceRepository implements ServiceRepositoryInterface
{
    public function __construct(
        protected ServiceRepository $repository,
    ) {}

    /**
     * @return CursorPaginator<int, Service>
     */
    public function getAllUserServices(): CursorPaginator
    {
        $key = ((string) Auth::id())
            .'_cursor-'.request()->string('cursor')->value()
            .'_include-'.request()->string('include')->value();

        return Cache::tags([CacheKeys::USER_SERVICES->value, Auth::id()])->remember(
            key: $key,
            ttl: config('cache.ttl.default'), // @phpstan-ignore-line
            callback: fn () => $this->repository->getAllUserServices()
        );
    }

    public function findService(string $id): Service
    {
        return Cache::tags([CacheKeys::SERVICE->value, Auth::id()])->remember(
            key: $id,
            ttl: config('cache.ttl.default'), // @phpstan-ignore-line
            callback: fn () => $this->repository->findService(id: $id)
        );
    }
}
