<?php

declare(strict_types=1);

use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\HealthController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')
    ->name('api.')
    ->group(function () {
        Route::get('/health', [HealthController::class, 'show'])->name('health');
        Route::get('/products', [ProductController::class, 'index'])->name('products.index');
        Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('products.show');

        Route::get('/cart', [CartController::class, 'show'])->name('cart.show');
        Route::post('/cart/items', [CartController::class, 'store'])->name('cart.items.store');
        Route::patch('/cart/items/{cartItem}', [CartController::class, 'update'])->name('cart.items.update');
        Route::delete('/cart/items/{cartItem}', [CartController::class, 'destroy'])->name('cart.items.destroy');
    });
