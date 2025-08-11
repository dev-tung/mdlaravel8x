<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\POS\ProductController;
use App\Http\Controllers\Admin\POS\ProductCategoryController;
use App\Http\Controllers\Admin\DashboardController;

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Product Categories routes
Route::prefix('pos/productcategory')->group(function () {
    Route::get('/', [ProductCategoryController::class, 'index'])->name('pos_productcategory_index');
    Route::get('/create', [ProductCategoryController::class, 'create'])->name('pos_productcategory_create');
    Route::post('/', [ProductCategoryController::class, 'store'])->name('pos_productcategory_store');
    Route::get('/{productcategory}/edit', [ProductCategoryController::class, 'edit'])->name('pos_productcategory_edit');
    Route::put('/{productcategory}', [ProductCategoryController::class, 'update'])->name('pos_productcategory_update');
    Route::delete('/{productcategory}', [ProductCategoryController::class, 'destroy'])->name('pos_productcategory_destroy');
});

// Product routes (chú ý: product, không phải products)
Route::prefix('pos/product')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('pos_product_index');
    Route::get('/create', [ProductController::class, 'create'])->name('pos_product_create');
    Route::post('/', [ProductController::class, 'store'])->name('pos_product_store');
    Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('pos_product_edit');
    Route::put('/{product}', [ProductController::class, 'update'])->name('pos_product_update');
    Route::delete('/{product}', [ProductController::class, 'destroy'])->name('pos_product_destroy');
});

