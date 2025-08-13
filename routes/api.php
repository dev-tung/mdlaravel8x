<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\POS\ProductController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// ======================= Product API =======================

Route::prefix('product')->group(function () {
    Route::get('/', [ProductController::class, 'index']);       // Danh sách sản phẩm
    Route::get('/{id}', [ProductController::class, 'show']);    // Chi tiết sản phẩm
    Route::post('/', [ProductController::class, 'store']);      // Thêm sản phẩm
    Route::put('/{id}', [ProductController::class, 'update']);  // Cập nhật sản phẩm
    Route::delete('/{id}', [ProductController::class, 'destroy']); // Xóa sản phẩm
});