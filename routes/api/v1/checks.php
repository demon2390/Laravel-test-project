<?php

declare(strict_types = 1);

use App\Http\Controllers\Api\V1\CheckController;
use App\Models\Check;
use Illuminate\Support\Facades\Route;

Route::controller(CheckController::class)->group(function () {
    Route::get('/', 'index')->can('viewAny', Check::class)->name('index');
    Route::post('/', 'store')->can('create', Check::class)->name('store');
    Route::get('{checks}', 'show,check')->name('show');
    Route::put('{checks}', 'update,check')->name('update');
    Route::delete('{checks}', 'delete,check')->name('delete');
});
