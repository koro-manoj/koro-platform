<?php

use Illuminate\Support\Facades\Route;
use Modules\Ecommerce\Http\Controllers\CartController;
use Modules\Ecommerce\Http\Controllers\ShopController;

Route::prefix('shop')->name('shop.')->group(function () {
    Route::get('/', [ShopController::class, 'index'])->name('index');
    Route::get('/products/{product:slug}', [ShopController::class, 'show'])->name('show');
    Route::get('/cart', [CartController::class, 'show'])->name('cart');
    Route::get('/checkout', [CartController::class, 'checkoutForm'])->name('checkout.form');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/items/{item}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/checkout', [CartController::class, 'checkout'])->name('checkout');
    Route::get('/checkout/success/{invoice:number}', [CartController::class, 'success'])->name('checkout.success');
    Route::get('/checkout/cancel/{invoice:number}', [CartController::class, 'cancel'])->name('checkout.cancel');
});
