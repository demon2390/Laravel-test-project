<?php

declare(strict_types = 1);

use App\Http\Controllers\Api\V1\{CheckController, CredentialController, ServiceController};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('headers')->group(static function (): void {
    Route::get('/', static function () {
        return [
            'Laravel' => app()->version(),
        ];
    })->middleware('sunset:' . now()->addYear());

    Route::prefix('v1')->as('v1:')
        ->middleware(['auth', 'auth:sanctum', 'throttle:api'])
        ->group(static function (): void {
            Route::get('user', static fn(Request $request) => $request->user())->name('user');

            Route::apiResources([
                'services'    => ServiceController::class,
                'checks'      => CheckController::class,
                'credentials' => CredentialController::class,
            ]);
        });
});
