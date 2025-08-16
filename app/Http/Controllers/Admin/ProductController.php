<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\ProductRepository;
use App\Repositories\TaxonomyRepository;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    protected $productRepository;
    protected $taxonomyRepository;

    public function __construct(
        ProductRepository $productRepository,
        TaxonomyRepository $taxonomyRepository
    ) {
        $this->productRepository = $productRepository;
        $this->taxonomyRepository = $taxonomyRepository;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['name', 'taxonomy_id', 'status']);
        $products = $this->productRepository->paginateWithFilters($filters, 15);

        $taxonomies = $this->taxonomyRepository->getByType('product');

        return view('admin.products.index', compact('products', 'filters', 'taxonomies'));
    }

    public function create()
    {
        $taxonomies = $this->taxonomyRepository->getByType('product');

        return view('admin.products.create', compact('taxonomies'));
    }

    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();
        $this->productRepository->create($data);

        return redirect()->route('admin.products.index')->with('success', 'Sản phẩm đã được tạo thành công.');
    }

    public function edit($id)
    {
        $product = $this->productRepository->find((int) $id);
        $taxonomies = $this->taxonomyRepository->getByType('product');

        return view('admin.products.edit', compact('product', 'taxonomies'));
    }

    public function update(UpdateProductRequest $request, $id)
    {
        $data = $request->validated();
        $this->productRepository->update($id, $data);

        return redirect()->route('admin.products.index')->with('success', 'Sản phẩm đã được cập nhật thành công.');
    }

    public function show($id)
    {
        $product = $this->productRepository->find((int) $id);
        return view('admin.products.show', compact('product'));
    }

    public function destroy($id)
    {
        $this->productRepository->delete($id);

        return redirect()->route('admin.products.index')->with('success', 'Sản phẩm đã được xóa.');
    }
}
