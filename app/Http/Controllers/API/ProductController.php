<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $service;

    public function __construct(ProductService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request): JsonResponse
    {
        $filters = $request->only(['name', 'category_id', 'status']);
        $perPage = 10;

        $products = $this->service->getProducts($filters, $perPage);

        // Trả về JSON chuẩn Laravel pagination
        return response()->json($products);
    }

    public function show($id): JsonResponse
    {
        return response()->json($this->service->getById($id));
    }

    public function store(Request $request): JsonResponse
    {
        $product = $this->service->create($request->all());
        return response()->json([
            'product' => $product,
            'route' => route('pos.product.index')
        ], 201);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $product = $this->service->update($id, $request->all());
        return response()->json($product);
    }

    public function destroy($id): JsonResponse
    {
        $this->service->delete($id);
        return response()->json(null, 204);
    }
}
