<?php

declare(strict_types = 1);

use App\Http\Controllers\Checks;
use Illuminate\Support\Facades\Route;

Route::get('/', \App\Http\Controllers\Api\V1\Checks\IndexController::class)->name('index');
Route::post('/', \App\Http\Controllers\Api\V1\Checks\StoreController::class)->name('store');
Route::get('{checks}', \App\Http\Controllers\Api\V1\Checks\ShowController::class)->name('show');
Route::put('{checks}', \App\Http\Controllers\Api\V1\Checks\UpdateController::class)->name('update');
Route::delete('{checks}', \App\Http\Controllers\Api\V1\Checks\DeleteController::class)->name('delete');
