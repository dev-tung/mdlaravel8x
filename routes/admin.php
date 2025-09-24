<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{
    CustomerController,
    ExpenseController,
    MediaController,
    PaymentController,
    PermissionController,
    PointController,
    ProductController,
    ImportController,
    ExportController,
    RoleController,
    SupplierController,
    TaxonomyController,
    UserController,
    DashboardController
};

Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::resource('imports', ImportController::class);
    Route::resource('exports', ExportController::class);
    Route::resource('customers', CustomerController::class);
    Route::resource('expenses', ExpenseController::class);
    Route::resource('media', MediaController::class);
    Route::resource('payments', PaymentController::class);
    Route::resource('permissions', PermissionController::class);
    Route::resource('points', PointController::class);
    Route::resource('products', ProductController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('suppliers', SupplierController::class);
    Route::resource('taxonomies', TaxonomyController::class);
    Route::resource('users', UserController::class);

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
});


Auth::routes();
