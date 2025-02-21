<?php

declare(strict_types = 1);

use App\Http\Controllers\Services;
use Illuminate\Support\Facades\Route;

Route::get('/', \App\Http\Controllers\Api\V1\Services\IndexController::class)->name('index');
Route::post('/', \App\Http\Controllers\Api\V1\Services\StoreController::class)->name('store');
Route::get('{service}', \App\Http\Controllers\Api\V1\Services\ShowController::class)->name('show');
Route::put('{service}', \App\Http\Controllers\Api\V1\Services\UpdateController::class)->name('update');
Route::delete('{service}', \App\Http\Controllers\Api\V1\Services\DeleteController::class)->name('delete');
