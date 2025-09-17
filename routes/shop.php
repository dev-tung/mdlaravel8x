<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Shop\ShopController;

Route::get('/', [ShopController::class, 'index'])->name('home');