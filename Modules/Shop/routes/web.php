<?php

use Illuminate\Support\Facades\Route;
use Modules\Shop\Http\Controllers\ShopController;
use Modules\Shop\Http\Controllers\ProductController;

//Route Produk
Route::get('/products', [ProductController::class, 'index'])->name('products.index');

//Route List Kategori
Route::get('/category/{categorySlug}', [ProductController::class, 'category'])->name('products.category');

//Route Kategori Produk
Route::get('/{categorySlug}/{productSlug}', [ProductController::class, 'show'])->name('products.show');



Route::resource('shop', ShopController::class)->names('shop');

