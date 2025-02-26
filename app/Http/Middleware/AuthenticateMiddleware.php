<?php

namespace App\Http\Middleware;

use Closure;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateMiddleware
{
    public function handle($request, Closure $next)
    {
        $tokenModel = PersonalAccessToken::findToken(
            $request->bearerToken()
        );

        if ($tokenModel) {
            auth()->setUser($tokenModel->tokenable()->first());
        } else {
            abort(Response::HTTP_UNAUTHORIZED, 'Unauthenticated');
        }

        return $next($request);
    }
}
