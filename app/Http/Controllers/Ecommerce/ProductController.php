<?php

namespace App\Http\Controllers\Ecommerce;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    function __construct() {
    }

    public function index(Request $request){
        return view('ecommerce.product.index');
    }
}
