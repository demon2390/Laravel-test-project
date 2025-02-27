<?php

declare(strict_types = 1);

namespace App\Repositories\Services\Decorators;

use App\Enums\CacheKeys;
use App\Repositories\Services\Interfaces\ServiceRepositoryInterface;
use App\Repositories\Services\ServiceRepository;
use Illuminate\Contracts\Cache\Repository as Cache;
use Illuminate\Database\Eloquent\Collection;

class CachedServiceRepository implements ServiceRepositoryInterface
{
    public function __construct(
        protected ServiceRepository $repository,
        protected Cache $cache
    ) {
    }

    public function getAllUserServices(): Collection
    {
        return $this->cache->tags(CacheKeys::USER_SERVICES->value)->remember(
            key: auth()->id(),
            ttl: config('cache.ttl.default'),
            callback: function () {
                return $this->repository->getAllUserServices();
            });
    }
}
