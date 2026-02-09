<?php

declare(strict_types=1);

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\ProductImageController;
use App\Http\Controllers\Payments\SslCommerzController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Storefront\CartController;
use App\Http\Controllers\Storefront\CheckoutController;
use App\Http\Controllers\Storefront\HomeController;
use App\Http\Controllers\Storefront\ProductController as StorefrontProductController;
use Illuminate\Support\Facades\Route;

Route::name('storefront.')
    ->group(function () {
        Route::get('/', [HomeController::class, 'index'])->name('home');
        Route::get('/products', [StorefrontProductController::class, 'index'])->name('products.index');
        Route::get('/products/{product:slug}', [StorefrontProductController::class, 'show'])->name('products.show');

        Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
        Route::post('/cart/items', [CartController::class, 'store'])->name('cart.add');
        Route::patch('/cart/items/{cartItem}', [CartController::class, 'update'])->name('cart.update');
        Route::delete('/cart/items/{cartItem}', [CartController::class, 'destroy'])->name('cart.remove');

        Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout.show');
        Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    });

Route::middleware('guest')->get('/admin/login', function () {
    return redirect()->route('login', ['admin' => '1']);
})->name('admin.login');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'admin'])
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('products', AdminProductController::class)->except(['show']);
        Route::post('products/{product}/images', [ProductImageController::class, 'store'])->name('products.images.store');
        Route::delete('products/{product}/images/{image}', [ProductImageController::class, 'destroy'])->name('products.images.destroy');

        Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
        Route::put('orders/{order}', [OrderController::class, 'update'])->name('orders.update');
    });

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('payments/sslcommerz')
    ->name('payments.sslcommerz.')
    ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class])
    ->group(function () {
        Route::match(['get', 'post'], '/success', [SslCommerzController::class, 'success'])->name('success');
        Route::match(['get', 'post'], '/fail', [SslCommerzController::class, 'fail'])->name('fail');
        Route::match(['get', 'post'], '/cancel', [SslCommerzController::class, 'cancel'])->name('cancel');
        Route::match(['get', 'post'], '/ipn', [SslCommerzController::class, 'ipn'])->name('ipn');
    });

require __DIR__.'/auth.php';
