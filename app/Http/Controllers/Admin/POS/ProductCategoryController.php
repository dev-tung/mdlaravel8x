<?php

namespace App\Http\Controllers\Admin\POS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    public function index()
    {
        return view('admin.pos.product_category.index');
    }

    public function create()
    {
        return view('admin.pos.product_category.create');
    }

    public function store(Request $request)
    {
        // Xử lý lưu loại sản phẩm
    }

    public function edit($id)
    {
        return view('admin.pos.product_category.edit', compact('id'));
    }

    public function update(Request $request, $id)
    {
        // Xử lý cập nhật loại sản phẩm
    }

    public function destroy($id)
    {
        // Xử lý xóa loại sản phẩm
    }
}
