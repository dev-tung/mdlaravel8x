<?php

namespace App\Http\Controllers\API\POS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ProductService;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        return response()->json($this->productService->getAll());
    }

    public function show($id)
    {
        $product = $this->productService->getById($id);
        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy sản phẩm'], 404);
        }
        return response()->json($product);
    }

    public function store(Request $request)
    {
        return response()->json(['success' => true, 'message' => 'Thêm sản phẩm thành công'], 201);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'category_id' => 'required|integer',
            'name'        => 'required|string|min:3',
            'slug'        => 'nullable|string|regex:/^[a-z0-9\-]+$/|unique:products,slug,' . $id,
            'sku'         => 'nullable|string|max:20',
            'price'       => 'required|numeric|min:0',
            'sale_price'  => 'nullable|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'status'      => 'required|in:0,1',
            'agree'       => 'required|boolean',
            'image'       => 'nullable|file|mimes:jpg,jpeg,png|max:2048'
        ]);

        $product = $this->productService->update($id, $validated);
        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy sản phẩm'], 404);
        }

        return response()->json(['success' => true, 'message' => 'Cập nhật sản phẩm thành công', 'data' => $product]);
    }

    public function destroy($id)
    {
        $deleted = $this->productService->delete($id);
        if (!$deleted) {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy sản phẩm'], 404);
        }
        return response()->json(['success' => true, 'message' => 'Xóa sản phẩm thành công']);
    }

    public function search(Request $request)
    {
        $keyword = $request->get('q', '');
        return response()->json($this->productService->search($keyword));
    }

    public function filter(Request $request)
    {
        return response()->json($this->productService->filter($request->all()));
    }
}
