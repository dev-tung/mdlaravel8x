<?php

namespace App\Http\Controllers\Admin\POS;

use App\Http\Controllers\Controller;

class SupplierController extends Controller
{
    public function index()
    {
        return view('admin.pos.supplier.index');
    }

    public function create()
    {
        return view('admin.pos.supplier.create');
    }

    public function edit($id)
    {
        return view('admin.pos.supplier.edit', compact('id'));
    }

    public function show($id)
    {
        return view('admin.pos.supplier.show', compact('id'));
    }
}
