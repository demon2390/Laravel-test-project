<?php

declare(strict_types = 1);

use App\Http\Controllers\Api\V1\CredentialController;
use App\Models\Credential;
use Illuminate\Support\Facades\Route;

Route::controller(CredentialController::class)->group(function () {
    Route::get('/', 'index')->can('viewAny', Credential::class)->name('index');
    Route::post('/', 'store')->can('create', Credential::class)->name('store');
    Route::get('{credential}', 'show,credential')->name('show');
    Route::put('{credential}', 'update,credential')->name('update');
    Route::delete('{credential}', 'delete,credential')->name('delete');
});

