<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
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

    public function index(): JsonResponse
    {
        return response()->json($this->service->getAll());
    }

    public function show($id): JsonResponse
    {
        return response()->json($this->service->getById($id));
    }

    public function store(Request $request): JsonResponse
    {
        $product = $this->service->create($request->all());
        return response()->json($product, 201);
    }

    public function update(UpdateProductRequest $request, $id): JsonResponse
    {
        $product = $this->service->update($id, $request->validated());
        return response()->json($product);
    }

    public function destroy($id): JsonResponse
    {
        $this->service->delete($id);
        return response()->json(null, 204);
    }
}
