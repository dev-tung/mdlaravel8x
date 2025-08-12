<?php

namespace App\Http\Controllers\Admin\POS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Services\ProductService;
use App\Models\ProductCategory;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    // Danh sách sản phẩm
    public function index()
    {
        $products = $this->productService->getAll();
        return view('admin.pos.product.index', compact('products'));
    }

    // Form thêm mới
    public function create()
    {
        $categories = ProductCategory::all();
        return view('admin.pos.product.create', compact('categories'));
    }

    // Lưu sản phẩm
    public function store(ProductRequest $request)
    {
        $data = $request->validated();
        $this->productService->create($data);
        return redirect()->route('pos.product.index')
                         ->with('success', 'Thêm sản phẩm thành công');
    }

    // Form chỉnh sửa
    public function edit($id)
    {
        $product = $this->productService->find($id);
        $categories = ProductCategory::all();
        return view('admin.pos.product.edit', compact('product', 'categories'));
    }

    // Cập nhật sản phẩm
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'description' => 'nullable|string',
            'category_id' => 'nullable|integer'
        ]);

        $this->productService->update($id, $data);

        return redirect()->route('pos.product.index')
                         ->with('success', 'Cập nhật sản phẩm thành công');
    }

    // Xóa sản phẩm
    public function destroy($id)
    {
        $this->productService->delete($id);
        return redirect()->route('pos.product.index')
                         ->with('success', 'Xóa sản phẩm thành công');
    }
}
