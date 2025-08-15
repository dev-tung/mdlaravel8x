<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\ProductCategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    protected ProductCategoryService $service;

    public function __construct(ProductCategoryService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request): JsonResponse
    {
        $filters = $request->only(['name']);
        $perPage = $request->get('per_page', 10);

        return response()->json(
            $this->service->getCategories($filters, $perPage)
        );
    }

    public function show(int $id): JsonResponse
    {
        return response()->json(
            $this->service->getById($id)
        );
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500'
        ]);

        $category = $this->service->create($validated);

        return response()->json([
            'category' => $category,
            'redirect_url' => route('pos.product_category.index')
        ], 201);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string|max:500'
        ]);

        return response()->json(
            $this->service->update($id, $validated)
        );
    }

    public function destroy(int $id): JsonResponse
    {
        $this->service->delete($id);
        return response()->json(null, 204);
    }
}
