<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::name('storefront.')
    ->group(function () {
        Route::get('/', function () {
            return view('welcome');
        })->name('home');
    });

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth'])
    ->group(function () {
        Route::get('/', function () {
            return response('Admin dashboard');
        })->name('dashboard');
    });
