<?php

declare(strict_types=1);

use App\Providers\AppServiceProvider;
use App\Providers\PolicyServiceProvider;
use App\Providers\RateLimitServiceProvider;

return [
    AppServiceProvider::class,
    PolicyServiceProvider::class,
    RateLimitServiceProvider::class,
];
