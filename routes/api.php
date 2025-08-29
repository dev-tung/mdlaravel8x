<?php
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\PurchaseController;

Route::post('orders/update-field/{id}', [OrderController::class, 'updateField'])
    ->name('api.orders.update-field');

Route::post('purchases/update-field/{id}', [PurchaseController::class, 'updateField'])
    ->name('api.purchases.update-field');