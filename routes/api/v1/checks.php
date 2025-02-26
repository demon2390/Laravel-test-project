<?php

declare(strict_types = 1);

use App\Http\Controllers\Api\V1\CheckController;
use Illuminate\Support\Facades\Route;

Route::controller(CheckController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/', 'store')->name('store');
    Route::get('{checks}', 'show')->name('show');
    Route::put('{checks}', 'update')->name('update');
    Route::delete('{checks}', 'delete')->name('delete');
});
