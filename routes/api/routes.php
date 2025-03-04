<?php

declare(strict_types=1);

use App\Http\Controllers\Api\V1\CheckController;
use App\Http\Controllers\Api\V1\CredentialController;
use App\Http\Controllers\Api\V1\ServiceController;
use App\Http\Resources\Api\V1\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('headers')->group(static function (): void {
    Route::prefix('v1')->as('v1:')
        ->middleware(['auth', 'auth:sanctum', 'throttle:api'])
        ->group(static function (): void {
            Route::get('user', static fn (Request $request): UserResource => new UserResource($request->user()))->name('user');

            Route::apiResources([
                'services' => ServiceController::class,
                'checks' => CheckController::class,
                'credentials' => CredentialController::class,
            ]);
        });
});
