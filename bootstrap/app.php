<?php

use App\Http\Middleware\ApiHeadersMiddleware;
use App\Http\Middleware\AuthenticateMiddleware;
use App\Http\Middleware\EnsureEmailIsVerified;
use App\Http\Middleware\LoggerMiddleware;
use App\Http\Middleware\SunsetMiddleware;
use App\Http\Middleware\XRequestIdMiddleware;
use App\Http\Responses\V1\MessageResponses;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web/routes.php',
        api: __DIR__ . '/../routes/api/routes.php',
        commands: __DIR__ . '/../routes/console/routes.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->statefulApi();
        $middleware->throttleWithRedis();
        $middleware->validateCsrfTokens(['*']);

        $middleware->api(prepend: [
            EnsureFrontendRequestsAreStateful::class,
            XRequestIdMiddleware::class,
            LoggerMiddleware::class,
        ]);

        $middleware->alias([
            'sunset'   => SunsetMiddleware::class,
            'verified' => EnsureEmailIsVerified::class,
            'auth'     => AuthenticateMiddleware::class,
            'headers'  => ApiHeadersMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->dontReportDuplicates();

        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            env('APP_DEBUG', false) ?: dd($e, $request);

            return new MessageResponses('Resource not found', Response::HTTP_NOT_FOUND);
        });

        $exceptions->render(function (Throwable $e, Request $request) {
            env('APP_DEBUG', false) ?: dd($e, $request);

            return new MessageResponses(
                $e->getMessage(),
                $e instanceof HttpExceptionInterface
                    ? $e->getStatusCode()
                    : Response::HTTP_INTERNAL_SERVER_ERROR
            );
        });
    })
    ->create();
