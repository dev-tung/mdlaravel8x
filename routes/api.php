<?php
use App\Http\Controllers\Api\{
    OrderController,
    PurchaseController,
    CustomerController,
    ProductController
};

Route::post('orders/update-field/{id}', [OrderController::class, 'updateField'])
    ->name('api.orders.update-field');

Route::post('purchases/update-field/{id}', [PurchaseController::class, 'updateField'])
    ->name('api.purchases.update-field');

Route::get('customers', [CustomerController::class, 'index'])
    ->name('api.customers.index');

Route::get('products', [ProductController::class, 'index'])
    ->name('api.products.index');