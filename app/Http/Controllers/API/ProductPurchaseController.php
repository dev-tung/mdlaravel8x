<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\PurchaseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductPurchaseController extends Controller
{
    protected PurchaseService $service;

    public function __construct(PurchaseService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request): JsonResponse
    {
        $filters = $request->only(['supplier_id', 'purchase_date']);
        $perPage = $request->get('per_page', 10);

        return response()->json(
            $this->service->getPurchases($filters, $perPage)
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
            'product_id' => 'required|integer',
            'supplier_id' => 'required|integer',
            'purchase_date' => 'required|date',
            'quantity' => 'required|numeric|min:1',
            'import_price' => 'required|numeric|min:0',
        ]);

        $purchase = $this->service->create($validated);

        return response()->json([
            'purchase' => $purchase,
            'redirect_url' => route('pos.purchase.index')
        ], 201);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $validated = $request->validate([
            'product_id' => 'sometimes|integer',
            'supplier_id' => 'sometimes|integer',
            'purchase_date' => 'sometimes|date',
            'quantity' => 'sometimes|numeric|min:1',
            'import_price' => 'sometimes|numeric|min:0',
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
