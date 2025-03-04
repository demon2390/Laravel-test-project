<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class ApiHeadersMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        /** @var Response $response */
        $response = $next($request);

        // Remove headers
        foreach (['X-Powered-By', 'x-powered-by', 'Server', 'server'] as $header) {
            header_remove($header);
            $response->headers->remove($header);
        }

        // Set response headers
        $response->headers->set('Accept', 'application/json');
        $response->headers->set('Content-Type', 'application/vnd.api+json');

        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('Referrer-Policy', 'no-referrer-when-downgrade');
        $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        $response->headers->set('Permissions-Policy', 'autoplay=(self), camera=(), encrypted-media=(self), fullscreen=(), geolocation=(self), '
            .'gyroscope=(self), magnetometer=(), microphone=(), midi=(), payment=(), sync-xhr=(self), usb=()');
        $response->headers->set('Expect-CT', 'enforce, max-age=30');

        return $response;
    }
}
