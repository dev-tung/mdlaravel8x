<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\ProductRepository;
use App\Repositories\TaxonomyRepository;
use App\Repositories\SupplierRepository;
use App\Services\ProductService;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected ProductRepository $productRepository;
    protected TaxonomyRepository $taxonomyRepository;
    protected SupplierRepository $supplierRepository;
    protected ProductService $productService;

    public function __construct(
        ProductRepository $productRepository,
        TaxonomyRepository $taxonomyRepository,
        SupplierRepository $supplierRepository,
        ProductService $productService
    ) {
        $this->productRepository = $productRepository;
        $this->taxonomyRepository = $taxonomyRepository;
        $this->supplierRepository = $supplierRepository;
        $this->productService = $productService;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['name', 'taxonomy_id', 'supplier_id']);
        $perPage = $request->input('per_page', config('shared.pagination_per_page', 15));

        $products = $this->productService->paginateWithFilters($filters, $perPage);
        $taxonomies = $this->taxonomyRepository->getByType('product');
        $suppliers = $this->supplierRepository->all();

        return view('admin.products.index', compact('products', 'filters', 'taxonomies', 'suppliers'));
    }

    public function create()
    {
        $taxonomies = $this->taxonomyRepository->getByType('product');
        $suppliers = $this->supplierRepository->all();
        return view('admin.products.create', compact('taxonomies', 'suppliers'));
    }

    public function store(ProductRequest $request)
    {
        $this->productService->create($request->validated());

        return redirect()->route('admin.products.index')
            ->with('success', 'Sản phẩm tạo thành công.');
    }

    public function edit(int $id)
    {
        $product = $this->productRepository->find($id);
        if (!$product) {
            return redirect()->route('admin.products.index')->with('error', 'Sản phẩm không tồn tại.');
        }
        $taxonomies = $this->taxonomyRepository->getByType('product');
        $suppliers = $this->supplierRepository->all();
        return view('admin.products.edit', compact('product', 'taxonomies', 'suppliers'));
    }

    public function update(ProductRequest $request, int $id)
    {
        $this->productService->update($id, $request->validated());
        return redirect()->route('admin.products.index')
            ->with('success', 'Sản phẩm đã được cập nhật.');
    }

    public function destroy(int $id)
    {
        try {
            $this->productService->delete($id);
            return redirect()->route('admin.products.index')
                ->with('success', 'Sản phẩm đã được xóa.');
        } catch (\Exception $e) {
            return redirect()->route('admin.products.index')
                ->with('error', 'Có lỗi xảy ra khi xóa sản phẩm.');
        }
    }

    public function show(int $id)
    {
        $product = $this->productRepository->find($id);
        if (!$product) {
            return redirect()->route('admin.products.index')->with('error', 'Sản phẩm không tồn tại.');
        }
        return view('admin.products.show', compact('product'));
    }
}