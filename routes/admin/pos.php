<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\POS\ProductController;
use App\Http\Controllers\Admin\POS\ProductPurchaseController;
use App\Http\Controllers\Admin\POS\SupplierController;
use App\Http\Controllers\Admin\POS\ExpenseController;
use App\Http\Controllers\Admin\POS\OrderController;
use App\Http\Controllers\Admin\POS\ProductCategoryController;
use App\Http\Controllers\Admin\POS\CustomerController;
use App\Http\Controllers\Admin\POS\UserController;

// Product
Route::get('product', [ProductController::class, 'index'])->name('pos.product.index');
Route::get('product/create', [ProductController::class, 'create'])->name('pos.product.create');
Route::post('product', [ProductController::class, 'store'])->name('pos.product.store');
Route::get('product/{id}', [ProductController::class, 'show'])->name('pos.product.show');
Route::get('product/{id}/edit', [ProductController::class, 'edit'])->name('pos.product.edit');
Route::put('product/{id}', [ProductController::class, 'update'])->name('pos.product.update');
Route::delete('product/{id}', [ProductController::class, 'destroy'])->name('pos.product.destroy');

// Purchase
Route::get('purchase', [ProductPurchaseController::class, 'index'])->name('pos.purchase.index');
Route::get('purchase/create', [ProductPurchaseController::class, 'create'])->name('pos.purchase.create');
Route::post('purchase', [ProductPurchaseController::class, 'store'])->name('pos.purchase.store');
Route::get('purchase/{id}', [ProductPurchaseController::class, 'show'])->name('pos.purchase.show');
Route::get('purchase/{id}/edit', [ProductPurchaseController::class, 'edit'])->name('pos.purchase.edit');
Route::put('purchase/{id}', [ProductPurchaseController::class, 'update'])->name('pos.purchase.update');
Route::delete('purchase/{id}', [ProductPurchaseController::class, 'destroy'])->name('pos.purchase.destroy');

// Supplier
Route::get('supplier', [SupplierController::class, 'index'])->name('pos.supplier.index');
Route::get('supplier/create', [SupplierController::class, 'create'])->name('pos.supplier.create');
Route::post('supplier', [SupplierController::class, 'store'])->name('pos.supplier.store');
Route::get('supplier/{id}', [SupplierController::class, 'show'])->name('pos.supplier.show');
Route::get('supplier/{id}/edit', [SupplierController::class, 'edit'])->name('pos.supplier.edit');
Route::put('supplier/{id}', [SupplierController::class, 'update'])->name('pos.supplier.update');
Route::delete('supplier/{id}', [SupplierController::class, 'destroy'])->name('pos.supplier.destroy');

// Expense
Route::get('expense', [ExpenseController::class, 'index'])->name('pos.expense.index');
Route::get('expense/create', [ExpenseController::class, 'create'])->name('pos.expense.create');
Route::post('expense', [ExpenseController::class, 'store'])->name('pos.expense.store');
Route::get('expense/{id}', [ExpenseController::class, 'show'])->name('pos.expense.show');
Route::get('expense/{id}/edit', [ExpenseController::class, 'edit'])->name('pos.expense.edit');
Route::put('expense/{id}', [ExpenseController::class, 'update'])->name('pos.expense.update');
Route::delete('expense/{id}', [ExpenseController::class, 'destroy'])->name('pos.expense.destroy');

// Order
Route::get('order', [OrderController::class, 'index'])->name('pos.order.index');
Route::get('order/create', [OrderController::class, 'create'])->name('pos.order.create');
Route::post('order', [OrderController::class, 'store'])->name('pos.order.store');
Route::get('order/{id}', [OrderController::class, 'show'])->name('pos.order.show');
Route::get('order/{id}/edit', [OrderController::class, 'edit'])->name('pos.order.edit');
Route::put('order/{id}', [OrderController::class, 'update'])->name('pos.order.update');
Route::delete('order/{id}', [OrderController::class, 'destroy'])->name('pos.order.destroy');

// Product Category
Route::get('product-category', [ProductCategoryController::class, 'index'])->name('pos.product_category.index');
Route::get('product-category/create', [ProductCategoryController::class, 'create'])->name('pos.product_category.create');
Route::post('product-category', [ProductCategoryController::class, 'store'])->name('pos.product_category.store');
Route::get('product-category/{id}', [ProductCategoryController::class, 'show'])->name('pos.product_category.show');
Route::get('product-category/{id}/edit', [ProductCategoryController::class, 'edit'])->name('pos.product_category.edit');
Route::put('product-category/{id}', [ProductCategoryController::class, 'update'])->name('pos.product_category.update');
Route::delete('product-category/{id}', [ProductCategoryController::class, 'destroy'])->name('pos.product_category.destroy');

// Customer
Route::get('customer', [CustomerController::class, 'index'])->name('pos.customer.index');
Route::get('customer/create', [CustomerController::class, 'create'])->name('pos.customer.create');
Route::post('customer', [CustomerController::class, 'store'])->name('pos.customer.store');
Route::get('customer/{id}', [CustomerController::class, 'show'])->name('pos.customer.show');
Route::get('customer/{id}/edit', [CustomerController::class, 'edit'])->name('pos.customer.edit');
Route::put('customer/{id}', [CustomerController::class, 'update'])->name('pos.customer.update');
Route::delete('customer/{id}', [CustomerController::class, 'destroy'])->name('pos.customer.destroy');

// User
Route::get('user', [UserController::class, 'index'])->name('pos.user.index');
Route::get('user/create', [UserController::class, 'create'])->name('pos.user.create');
Route::post('user', [UserController::class, 'store'])->name('pos.user.store');
Route::get('user/{id}', [UserController::class, 'show'])->name('pos.user.show');
Route::get('user/{id}/edit', [UserController::class, 'edit'])->name('pos.user.edit');
Route::put('user/{id}', [UserController::class, 'update'])->name('pos.user.update');
Route::delete('user/{id}', [UserController::class, 'destroy'])->name('pos.user.destroy');
