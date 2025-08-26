<?php
use App\Http\Controllers\Api\OrderController;

Route::post('orders/update-field/{id}', [OrderController::class, 'updateField'])
    ->name('api.orders.update-field');

