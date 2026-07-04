<?php

use Illuminate\Support\Facades\Route;
use Modules\Api\Http\Controllers\V1\AuthController;
use Modules\Api\Http\Controllers\V1\ProductController;
use Modules\Api\Http\Controllers\V1\ResourceController;

Route::prefix('v1')->name('v1.')->group(function () {
    Route::post('/auth/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/auth/logout', [AuthController::class, 'logout']);
        Route::get('/auth/me', [AuthController::class, 'me']);
        Route::get('/products', [ProductController::class, 'index']);
        Route::get('/products/{product}', [ProductController::class, 'show']);
        Route::get('/invoices', [ResourceController::class, 'invoices']);
        Route::get('/contacts', [ResourceController::class, 'contacts']);
        Route::get('/pages', [ResourceController::class, 'pages']);
        Route::get('/inventory', [ResourceController::class, 'inventory']);
    });
});
