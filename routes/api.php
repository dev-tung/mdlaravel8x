<?php
use App\Http\Controllers\Api\{
    ExportController,
    ImportController,
    CustomerController,
    ProductController
};

Route::post('exports/update-field/{id}', [ExportController::class, 'updateField'])
    ->name('api.exports.update-field');

Route::post('imports/update-field/{id}', [ImportController::class, 'updateField'])
    ->name('api.imports.update-field');

Route::get('customers', [CustomerController::class, 'index'])
    ->name('api.customers.index');

Route::get('products', [ProductController::class, 'index'])
    ->name('api.products.index');