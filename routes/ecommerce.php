<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Ecommerce\{
    HomeController,
    ProductController
};

Route::get('/', [HomeController::class, 'index'])->name('home.index');

Route::get('products/{taxonomy?}', [ProductController::class, 'index'])->name('product.index');
Route::get('product/{slug}', [ProductController::class, 'show'])->name('product.detail');