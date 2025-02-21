<?php

declare(strict_types = 1);

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->as('v1:')->group(static function (): void {
    Route::middleware([/*'auth:sanctum', */'throttle:api'])->group(static function (): void {
        Route::get('user', static fn(Request $request) => $request->user())->name('user');

        Route::prefix('services')->as('services:')->group(base_path(
            path: 'routes/api/v1/services.php',
        ));

        Route::prefix('credentials')->as('credentials:')->group(base_path(
            path: 'routes/api/v1/credentials.php',
        ));

        Route::prefix('checks')->as('checks:')->group(base_path(
            path: 'routes/api/v1/checks.php',
        ));
    });
});

Route::middleware(['web'])->group(static function (): void {
    Route::get('/', function () {
        return ['Laravel' => app()->version()];
    })
        ->middleware('sunset:' . now()->addYear());

    Route::post('/register', [RegisteredUserController::class, 'store'])
        ->middleware('guest')
        ->name('register');

    Route::post('/login', [AuthenticatedSessionController::class, 'store'])
        ->middleware('guest')
        ->name('login');

    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
        ->middleware('guest')
        ->name('password.email');

    Route::post('/reset-password', [NewPasswordController::class, 'store'])
        ->middleware('guest')
        ->name('password.store');

    Route::get('/verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['auth', 'signed', 'throttle:auth'])
        ->name('verification.verify');

    Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware(['auth', 'throttle:auth'])
        ->name('verification.send');

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->middleware('auth')
        ->name('logout');
});
