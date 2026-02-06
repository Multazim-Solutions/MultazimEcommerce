<?php

declare(strict_types=1);

use App\Http\Controllers\Api\HealthController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')
    ->name('api.')
    ->group(function () {
        Route::get('/health', [HealthController::class, 'show'])->name('health');
    });
