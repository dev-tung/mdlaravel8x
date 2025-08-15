<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    // Hiển thị trang tổng quan
    public function dashboard()
    {
        // Bạn có thể truyền dữ liệu cần thiết ra view admin
        return view('admin.dashboard');
    }
}
