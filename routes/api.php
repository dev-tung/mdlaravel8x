<?php
use App\Http\Controllers\Api\{
    ExportController,
    ImportController,
    CustomerController,
    ProductController,
    SupplierController,
    ImportItemController,
    ExportItemController
};

Route::post('exports/update-field/{id}', [ExportController::class, 'updateField'])
    ->name('api.exports.update-field');

Route::post('imports/update-field/{id}', [ImportController::class, 'updateField'])
    ->name('api.imports.update-field');

Route::get('customers', [CustomerController::class, 'index'])
    ->name('api.customers.index');

Route::get('products', [ProductController::class, 'index'])
    ->name('api.products.index');

Route::get('suppliers', [SupplierController::class, 'index'])
    ->name('api.suppliers.index');

Route::get('import-items/by-import/{importId}', [ImportItemController::class, 'getItemsByImportId'])
    ->name('api.import-items.by-import');

Route::get('export-items/by-export/{exportId}', [ExportItemController::class, 'getItemsByExportId'])
    ->name('api.export-items.by-export');