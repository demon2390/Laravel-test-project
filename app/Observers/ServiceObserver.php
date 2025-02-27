<?php

declare(strict_types = 1);

namespace App\Observers;

use App\Enums\CacheKeys;
use App\Models\Service;
use Illuminate\Support\Facades\Cache;

readonly class ServiceObserver
{
    public function created(Service $service): void
    {
        $this->forgetServicesForUser($service->user_id);
    }

    protected function forgetServicesForUser(string $id): void
    {
        Cache::tags(CacheKeys::USER_SERVICES->value)->forget($id);
    }

    public function updated(Service $service): void
    {
        $this->forgetServicesForUser($service->user_id);
    }

    public function deleted(Service $service): void
    {
        $this->forgetServicesForUser($service->user_id);
    }

    public function forceDeleted(Service $service): void
    {
        $this->forgetServicesForUser($service->user_id);
    }
}
