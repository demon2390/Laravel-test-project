<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Service;
use Illuminate\Support\Facades\Cache;

final readonly class ServiceObserver
{
    public function created(Service $service): void
    {
        $this->forgetServicesForUser($service->user_id);
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

    private function forgetServicesForUser(string $userId): void
    {
        Cache::tags($userId)->clear();
    }
}
