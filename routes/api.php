<?php
use App\Http\Controllers\Api\OrderApiController;

Route::post('orders/update-field/{id}', [OrderApiController::class, 'updateField'])
    ->name('api.orders.update-field');

