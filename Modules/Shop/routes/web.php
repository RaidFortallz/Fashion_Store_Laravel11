<?php

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;
use Modules\Shop\Http\Controllers\CartController;
use Modules\Shop\Http\Controllers\OrderController;
use Modules\Shop\Http\Controllers\PaymentController;
use Modules\Shop\Http\Controllers\ShopController;
use Modules\Shop\Http\Controllers\ProductController;
use Modules\Shop\Http\Controllers\AddressController;

//Route Produk
Route::get('/products', [ProductController::class, 'index'])->name('products.index');

//Route List Kategori
Route::get('/category/{categorySlug}', [ProductController::class, 'category'])->name('products.category');

//Route Filter Produk Tag
Route::get('/tag/{tagSlug}', [ProductController::class, 'tag'])->name('products.tag');


//Route Pembayaran
Route::post('/payments/midtrans', [PaymentController::class, 'midtrans'])
->withoutMiddleware([VerifyCsrfToken::class])->name('payments.midtrans');


//Route Keranjang & Checkout
Route::middleware(['auth'])->group(function() {
    Route::get('orders/checkout', [OrderController::class, 'checkout'])->name('orders.checkout');
    Route::post('orders/checkout', [OrderController::class, 'store'])->name('orders.store');
    Route::post('orders/shipping-fee', [OrderController::class, 'shippingFee'])->name('orders.shipping_fee');
    
    Route::post('orders/choose_package', [OrderController::class, 'choosePackage'])->name('orders.choose_package');

    Route::get('/carts', [CartController::class, 'index'])->name('carts.index');
    Route::get('/carts/{id}/remove', [CartController::class, 'destroy'])->name('carts.destroy');
    Route::post('/carts', [CartController::class, 'store'])->name('carts.store');
    Route::put('/carts', [CartController::class, 'update'])->name('carts.update');
});

//Route Kategori Produk
Route::get('/{categorySlug}/{productSlug}', [ProductController::class, 'show'])->name('products.show');

Route::get('/search-destination', [OrderController::class, 'searchDestination'])->name('public.search-destination');

//Route Kategori alamat
Route::middleware('auth')->group(function () {
    Route::post('/addresses', [AddressController::class, 'store'])->name('addresses.store');
    Route::delete('/addresses/{address}', [AddressController::class, 'destroy'])->name('addresses.destroy');
});


