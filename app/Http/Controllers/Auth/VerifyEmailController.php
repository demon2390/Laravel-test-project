<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\EmailVerificationRequest;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): JsonResponse
    {
        /** @var User $user */
        $user = User::query()->findOrFail($request->route('id'));

        if (!hash_equals(sha1($user->getEmailForVerification()), $request->route('hash'))) { // @phpstan-ignore-line
            return response()->json([
                'message' => 'Verification failed',
            ], Response::HTTP_NOT_ACCEPTABLE);
        }

        if ($user->hasVerifiedEmail()) {
            return response()->json([
                'message' => 'Email is already verified',
            ], Response::HTTP_NOT_ACCEPTABLE);
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($request->user())); // @phpstan-ignore-line
        }

        return response()->json([
            'message' => 'Email is verified',
        ], Response::HTTP_CREATED);
    }
}
