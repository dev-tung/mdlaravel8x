<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\POS\ProductController;

Route::prefix('product')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('pos.product.index');
    Route::get('/create', [ProductController::class, 'create'])->name('pos.product.create');
    Route::get('/store', [ProductController::class, 'store'])->name('pos.product.store');
});
