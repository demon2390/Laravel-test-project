<?php

declare(strict_types = 1);

namespace App\Observers;

use App\Enums\CacheKeys;
use App\Models\Service;
use Illuminate\Support\Facades\Cache;

class ServiceObserver
{
    public function created(Service $service): void
    {
        $this->forgetServicesForUser($service->user_id);
        Cache::rememberForever(CacheKeys::SERVICE->value . '_' . $service->id, fn() => $service);
    }

    protected function forgetServicesForUser(string $id): void
    {
        Cache::forget(CacheKeys::USER_SERVICES->value . '_' . $id);
    }

    public function updated(Service $service): void
    {
        $this->forgetServicesForUser($service->user_id);
        $this->forgetService($service->id);
    }

    protected function forgetService(string $id): void
    {
        Cache::forget(CacheKeys::SERVICE->value . '_' . $id);
    }

    public function deleted(Service $service): void
    {
        $this->forgetServicesForUser($service->user_id);
        $this->forgetService($service->id);
    }

    public function forceDeleted(Service $service): void
    {
        $this->forgetServicesForUser($service->user_id);
        $this->forgetService($service->id);
    }
}
