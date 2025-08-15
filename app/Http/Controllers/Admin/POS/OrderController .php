<?php

namespace App\Http\Controllers\Admin\POS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        return view('admin.pos.order.index');
    }

    public function create()
    {
        return view('admin.pos.order.create');
    }

    public function store(Request $request)
    {
        // Xử lý lưu đơn hàng
    }

    public function edit($id)
    {
        return view('admin.pos.order.edit', compact('id'));
    }

    public function update(Request $request, $id)
    {
        // Xử lý cập nhật đơn hàng
    }

    public function destroy($id)
    {
        // Xử lý xóa đơn hàng
    }
}
