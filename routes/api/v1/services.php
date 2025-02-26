<?php

declare(strict_types = 1);

use App\Http\Controllers\Api\V1\ServiceController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ServiceController::class, 'index'])->name('index');
Route::post('/', [ServiceController::class, 'store'])->name('store');
Route::get('{service}', [ServiceController::class, 'show'])->name('show');
Route::put('{service}', [ServiceController::class, 'update'])->name('update');
Route::delete('{service}', [ServiceController::class, 'delete'])->name('delete');
