<?php

declare(strict_types = 1);

use App\Http\Controllers\Api\V1\ServiceController;
use App\Models\Service;
use Illuminate\Support\Facades\Route;

Route::controller(ServiceController::class)->group(function () {
    Route::get('/', 'index')->can('viewAny', Service::class)->name('index');
    Route::post('/', 'store')->can('create', Service::class)->name('store');
    Route::get('{service}', 'show')->can('view,service')->name('show');
    Route::put('{service}', 'update')->can('update,service')->name('update');
    Route::delete('{service}', 'delete')->can('delete,service')->name('delete');
});
