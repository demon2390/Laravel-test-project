<?php

use App\Http\Middleware\EnsureEmailIsVerified;
use App\Http\Middleware\SunsetMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: __DIR__ . '/../routes/api/routes.php',
        commands: __DIR__ . '/../routes/console/routes.php',
        health: '/up',
        apiPrefix: '',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->throttleWithRedis();

        $middleware->api(prepend: [
            EnsureFrontendRequestsAreStateful::class,
        ]);

        $middleware->alias([
            'sunset'   => SunsetMiddleware::class,
            'verified' => EnsureEmailIsVerified::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->dontReportDuplicates();

        $exceptions->render(function (Throwable $e, Request $request) {
            $code = $e->getStatusCode() ?: 500;
            return response()->json([
                'code'     => $code,
                'detail'   => $e->getMessage(),
            ], $code);
        });
    })->create();
