<?php

namespace App\Http\Controllers\Admin\POS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index()
    {
        return view('admin.pos.expense.index');
    }

    public function create()
    {
        return view('admin.pos.expense.create');
    }

    public function store(Request $request)
    {
        // Xử lý lưu chi phí
    }

    public function edit($id)
    {
        return view('admin.pos.expense.edit', compact('id'));
    }

    public function update(Request $request, $id)
    {
        // Xử lý cập nhật chi phí
    }

    public function destroy($id)
    {
        // Xử lý xóa chi phí
    }
}
