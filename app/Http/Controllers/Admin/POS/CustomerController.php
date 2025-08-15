<?php

namespace App\Http\Controllers\Admin\POS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        return view('admin.pos.customer.index');
    }

    public function create()
    {
        return view('admin.pos.customer.create');
    }

    public function store(Request $request)
    {
        // Xử lý lưu khách hàng
    }

    public function edit($id)
    {
        return view('admin.pos.customer.edit', compact('id'));
    }

    public function update(Request $request, $id)
    {
        // Xử lý cập nhật khách hàng
    }

    public function destroy($id)
    {
        // Xử lý xóa khách hàng
    }
}
