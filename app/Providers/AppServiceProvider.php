<?php

namespace App\Providers;

use App\Models\Service;
use App\Repositories\Services\Decorators\CachedServiceRepository;
use App\Repositories\Services\Interfaces\ServiceRepositoryInterface;
use App\Repositories\Services\ServiceRepository;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(ServiceRepositoryInterface::class, function () {
            $baseRepo = new ServiceRepository(new Service);
            $cachingRepo = new CachedServiceRepository($baseRepo, $this->app['cache.store']);

            return $cachingRepo;
        });
    }

    public function boot(): void
    {
        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
//            return config('app.frontend_url')."/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
            return config('app.url') . "/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
        });
    }
}
