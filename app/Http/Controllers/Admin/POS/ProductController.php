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

    public function edit($id)
    {
        return view('admin.pos.product.edit', compact('id'));
    }

    public function show($id)
    {
        return view('admin.pos.product.show', compact('id'));
    }
}
