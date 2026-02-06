<?php

declare(strict_types=1);

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')
    ->name('api.')
    ->group(function () {
        Route::get('/health', function (Request $request) {
            return response()->json([
                'status' => 'ok',
            ]);
        })->name('health');
    });
