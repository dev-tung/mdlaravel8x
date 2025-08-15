<?php

namespace App\Http\Controllers\Admin\POS;

use App\Http\Controllers\Controller;

class ProductPurchaseController extends Controller
{
    public function index()
    {
        return view('admin.pos.purchase.index');
    }

    public function create()
    {
        return view('admin.pos.purchase.create');
    }

    public function edit($id)
    {
        return view('admin.pos.purchase.edit', compact('id'));
    }

    public function show($id)
    {
        return view('admin.pos.purchase.show', compact('id'));
    }
}
