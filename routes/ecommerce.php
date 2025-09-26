<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Ecommerce\{
    HomeController,
    ProductController
};

Route::get('/', function () {
    return redirect()->route('login'); // redirect bằng route name
});

// Route::get('products/{taxonomy?}', [ProductController::class, 'index'])->name('product.index');
// Route::get('product/{slug}', [ProductController::class, 'show'])->name('product.detail');