<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::prefix('products')->group(function () {
    Route::get('/', 'App\Http\Controllers\ProductController@index');       // Danh sách sản phẩm
    Route::get('/{id}', 'App\Http\Controllers\ProductController@show');    // Chi tiết sản phẩm
    Route::post('/', 'App\Http\Controllers\ProductController@store');      // Thêm sản phẩm
    Route::put('/{id}', 'App\Http\Controllers\ProductController@update');  // Cập nhật sản phẩm
    Route::delete('/{id}', 'App\Http\Controllers\ProductController@destroy'); // Xóa sản phẩm
});

// ======================= Category API =======================
Route::prefix('categories')->group(function () {
    Route::get('/', 'App\Http\Controllers\CategoryController@index');     
    Route::get('/{id}', 'App\Http\Controllers\CategoryController@show');  
    Route::post('/', 'App\Http\Controllers\CategoryController@store');    
    Route::put('/{id}', 'App\Http\Controllers\CategoryController@update');
    Route::delete('/{id}', 'App\Http\Controllers\CategoryController@destroy');
});