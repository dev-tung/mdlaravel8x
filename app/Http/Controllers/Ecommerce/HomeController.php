<?php

namespace App\Http\Controllers\Ecommerce;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    function __construct() {
    }

    public function index(Request $request){
        return view('ecommerce.home.index');
    }
}
