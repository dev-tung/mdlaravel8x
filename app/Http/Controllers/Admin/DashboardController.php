<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    // Hiển thị trang tổng quan
    public function index()
    {
        // Bạn có thể truyền dữ liệu cần thiết ra view dashboard
        return view('admin.dashboard');
    }
}
