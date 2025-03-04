<?php

declare(strict_types=1);

namespace App\Providers;

use App\Repositories\Services\Decorators\CachedServiceRepository;
use App\Repositories\Services\Interfaces\ServiceRepositoryInterface;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\ServiceProvider;

final class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ServiceRepositoryInterface::class, CachedServiceRepository::class);
    }

    public function boot(): void
    {
        ResetPassword::createUrlUsing(static function (object $notifiable, string $token): string { // @phpstan-ignore-line
            //            return config('app.frontend_url')."/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
            return config('app.url')."/password-reset/{$token}?email={$notifiable->getEmailForPasswordReset()}"; // @phpstan-ignore-line
        });
    }
}
