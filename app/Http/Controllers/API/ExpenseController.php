<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\ExpenseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    protected ExpenseService $service;

    public function __construct(ExpenseService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request): JsonResponse
    {
        $filters = $request->only(['name', 'date']);
        $perPage = $request->get('per_page', 10);

        return response()->json(
            $this->service->getExpenses($filters, $perPage)
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
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'note' => 'nullable|string|max:500'
        ]);

        $expense = $this->service->create($validated);

        return response()->json([
            'expense' => $expense,
            'redirect_url' => route('pos.expense.index')
        ], 201);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'amount' => 'sometimes|numeric|min:0',
            'date' => 'sometimes|date',
            'note' => 'nullable|string|max:500'
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
