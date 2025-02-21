<?php

declare(strict_types = 1);

use App\Http\Controllers\Credentials;
use Illuminate\Support\Facades\Route;

Route::get('/', \App\Http\Controllers\Api\V1\Credentials\IndexController::class)->name('index');
Route::post('/', \App\Http\Controllers\Api\V1\Credentials\StoreController::class)->name('store');
Route::get('{credential}', \App\Http\Controllers\Api\V1\Credentials\ShowController::class)->name('show');
Route::put('{credential}', \App\Http\Controllers\Api\V1\Credentials\UpdateController::class)->name('update');
Route::delete('{credential}', \App\Http\Controllers\Api\V1\Credentials\DeleteController::class)->name('delete');
