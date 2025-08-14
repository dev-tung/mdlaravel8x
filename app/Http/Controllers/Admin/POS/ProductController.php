<?php

namespace App\Http\Controllers\Admin\POS;

use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function index()
    {
        return view('admin.pos.product.index');
    }

    public function create()
    {
        return view('admin.pos.product.create');
    }
}
