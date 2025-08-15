<?php

namespace App\Http\Controllers\Admin\POS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.pos.user.index');
    }

    public function create()
    {
        return view('admin.pos.user.create');
    }

    public function store(Request $request)
    {
        // Xử lý lưu người dùng
    }

    public function edit($id)
    {
        return view('admin.pos.user.edit', compact('id'));
    }

    public function update(Request $request, $id)
    {
        // Xử lý cập nhật người dùng
    }

    public function destroy($id)
    {
        // Xử lý xóa người dùng
    }
}
