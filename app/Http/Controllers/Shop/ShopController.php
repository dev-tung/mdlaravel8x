<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;

class ShopController extends Controller
{
    public function index()
    {
        // Trang chủ shop
        return view('shop.home');
    }
}
