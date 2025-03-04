<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateMiddleware
{
    public function handle(Request $request, Closure $next): mixed
    {
        $tokenModel = PersonalAccessToken::findToken(
            $request->bearerToken() ?: ''
        );

        if ($tokenModel) {
            /** @var User $user */
            $user = $tokenModel->tokenable()->first();

            Auth::setUser($user);
        } else {
            abort(Response::HTTP_UNAUTHORIZED, 'Unauthenticated');
        }

        return $next($request);
    }
}
