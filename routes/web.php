<?php

declare(strict_types=1);

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Storefront\HomeController;
use Illuminate\Support\Facades\Route;

Route::name('storefront.')
    ->group(function () {
        Route::get('/', [HomeController::class, 'index'])->name('home');
    });

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth'])
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    });
