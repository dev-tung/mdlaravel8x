<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected OrderService $service;

    public function __construct(OrderService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request): JsonResponse
    {
        $filters = $request->only(['customer_id', 'status', 'order_date']);
        $perPage = $request->get('per_page', 10);

        return response()->json(
            $this->service->getOrders($filters, $perPage)
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
            'customer_id' => 'required|integer',
            'order_date' => 'required|date',
            'status' => 'required|string|max:50',
            'total_amount' => 'required|numeric|min:0'
        ]);

        $order = $this->service->create($validated);

        return response()->json([
            'order' => $order,
            'redirect_url' => route('pos.order.index')
        ], 201);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $validated = $request->validate([
            'customer_id' => 'sometimes|integer',
            'order_date' => 'sometimes|date',
            'status' => 'sometimes|string|max:50',
            'total_amount' => 'sometimes|numeric|min:0'
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
