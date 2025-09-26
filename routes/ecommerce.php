<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Ecommerce\{
    HomeController,
    ProductController
};

Route::get('/', function () {
    abort(503);
});



// Route::get('products/{taxonomy?}', [ProductController::class, 'index'])->name('product.index');
// Route::get('product/{slug}', [ProductController::class, 'show'])->name('product.detail');