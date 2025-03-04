<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Check;
use App\Models\Credential;
use App\Models\Service;
use App\Policies\CheckPolicy;
use App\Policies\CredentialPolicy;
use App\Policies\ServicePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

final class PolicyServiceProvider extends ServiceProvider
{
    protected $policies = [
        Service::class => ServicePolicy::class,
        Credential::class => CredentialPolicy::class,
        Check::class => CheckPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
