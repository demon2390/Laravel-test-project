<?php

declare(strict_types = 1);

namespace App\Providers;

use App\Models\{Check, Credential, Service};
use App\Policies\{CheckPolicy, CredentialPolicy, ServicePolicy};
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class PolicyServiceProvider extends ServiceProvider
{
    protected $policies = [
        Service::class    => ServicePolicy::class,
        Credential::class => CredentialPolicy::class,
        Check::class      => CheckPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
