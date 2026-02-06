<?php

declare(strict_types=1);

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Storefront\CartController;
use App\Http\Controllers\Storefront\CheckoutController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Storefront\ProductController;
use Illuminate\Support\Facades\Route;

Route::name('storefront.')
    ->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('home');
        Route::get('/products', [ProductController::class, 'index'])->name('products.index');
        Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('products.show');

        Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
        Route::post('/cart/items', [CartController::class, 'store'])->name('cart.add');
        Route::patch('/cart/items/{cartItem}', [CartController::class, 'update'])->name('cart.update');
        Route::delete('/cart/items/{cartItem}', [CartController::class, 'destroy'])->name('cart.remove');

        Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout.show');
        Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    });

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'admin'])
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    });

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
