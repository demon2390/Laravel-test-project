<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\EmailVerificationRequest;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): JsonResponse
    {
        $user = User::query()->findOrFail($request->route('id'));

        if (! hash_equals(sha1($user->getEmailForVerification()), (string) $request->route('hash'))) {
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
            event(new Verified(request()->user()));
        }

        return response()->json([
            'message' => 'Email is verified',
        ], Response::HTTP_CREATED);
    }
}
