<?php

declare(strict_types = 1);

use App\Http\Controllers\Api\V1\CredentialController;
use Illuminate\Support\Facades\Route;

Route::controller(CredentialController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/', 'store')->name('store');
    Route::get('{credential}', 'show')->name('show');
    Route::put('{credential}', 'update')->name('update');
    Route::delete('{credential}', 'delete')->name('delete');
});

