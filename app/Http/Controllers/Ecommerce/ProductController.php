<?php

namespace App\Http\Controllers\Ecommerce;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\ProductRepository;
use App\Repositories\TaxonomyRepository;

class ProductController extends Controller
{
    
    protected ProductRepository $productRepository;
    protected TaxonomyRepository $taxonomyRepository;

    function __construct(ProductRepository $productRepository, TaxonomyRepository $taxonomyRepository) {
        $this->productRepository = $productRepository;
        $this->taxonomyRepository = $taxonomyRepository;
    }

    public function index(Request $request){
        $filters = $request->only(['name', 'taxonomy_id']);
        if (!empty($request->taxonomy)) {
            $taxonomy = $this->taxonomyRepository->findBySlug($request->taxonomy);
            if ($taxonomy) {
                $filters['taxonomy_id'] = $taxonomy->id;
            }
        }
        $perPage = $request->input('per_page', config('shared.pagination_per_page', 15));

        $filters['quantity'] = true; // Chỉ hiển thị sản phẩm còn hàng
        $products = $this->productRepository->paginateWithFilters($filters, $perPage);
        return view('ecommerce.products.index', compact('products'));
    }

    public function show(string $slug)
    {
        $product = $this->productRepository->findBySlug($slug);

        if (!$product) {
            abort(404);
        }

        return view('ecommerce.products.detail', compact('product'));
    }
}
