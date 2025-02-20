<?php

declare(strict_types = 1);

use App\Http\Controllers\Checks;
use Illuminate\Support\Facades\Route;

Route::get('/', Checks\IndexController::class)->name('index');
Route::post('/', Checks\StoreController::class)->name('store');
Route::get('{checks}', Checks\ShowController::class)->name('show');
Route::put('{checks}', Checks\UpdateController::class)->name('update');
Route::delete('{checks}', Checks\DeleteController::class)->name('delete');
