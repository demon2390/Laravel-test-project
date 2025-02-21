<?php

declare(strict_types = 1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\Response;

class SunsetMiddleware
{
    public function handle(Request $request, Closure $next, string $date): Response
    {
        /** @var Response $response */
        $response = $next($request);

        $response->headers->set(
            key: 'Sunset',
            values: Carbon::parse($date)->toRfc7231String(),
        );

        $response->headers->set(
            key: 'Deprecated',
            values: now()->gte($date) ? 'true' : 'false',
        );

        return $response;
    }
}
