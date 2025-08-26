<?php

namespace App\Http\Controllers\Ecommerce;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\ProductRepository;

class ProductController extends Controller
{
    
    protected ProductRepository $productRepository;

    function __construct(ProductRepository $productRepository) {
        $this->productRepository = $productRepository;
    }

    public function index(Request $request){
        return view('ecommerce.product.index');
    }

    public function show(string $slug)
    {
        $product = $this->productRepository->findBySlug($slug);

        if (!$product) {
            abort(404);
        }

        return view('products.show', compact('product'));
    }
}
