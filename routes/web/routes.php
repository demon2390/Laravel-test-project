<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', static fn () => view('welcome', ['base_url' => env('APP_URL', '/')]));

Route::middleware('headers')->group(static function (): void {
    Route::post('/register', [RegisteredUserController::class, 'store'])
        ->middleware('throttle:auth')
        ->name('register');

    Route::get('/verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:auth'])
        ->name('verification.verify');

    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
        ->middleware(['throttle:auth'])
        ->name('password.email');

    Route::post('/reset-password', [NewPasswordController::class, 'store'])
        ->middleware(['throttle:auth'])
        ->name('password.store');
});

Route::get('/password-reset/{token}', static fn (Request $request) => view('reset-password', [
    'token' => $request->route('token'),
    'email' => $request->query('email'),
]))
    ->middleware(['throttle:api'])
    ->name('password.reset');

// Not using in REST
//    Route::post('/login', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'store'])
//        ->middleware('guest')
//        ->name('login');
//
//    Route::post('/email/verification-notification', [\App\Http\Controllers\Auth\EmailVerificationNotificationController::class, 'store'])
//        ->middleware(['auth', 'throttle:6,1'])
//        ->name('verification.send');
//
//    Route::post('/logout', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'destroy'])
//        ->middleware('auth')
//        ->name('logout');
