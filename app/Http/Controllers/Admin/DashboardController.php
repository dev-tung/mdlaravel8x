<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\DashboardRepository;
use Carbon\Carbon;

class DashboardController extends Controller
{
    protected $repository;

    public function __construct(DashboardRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        
        return view('admin.dashboard');
    }
}
