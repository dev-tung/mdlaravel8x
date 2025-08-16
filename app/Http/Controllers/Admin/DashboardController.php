<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Hiển thị trang Dashboard Admin
     */
    public function index()
    {
        // Trả về view admin.dashboard
        return view('admin.dashboard');
    }
}
