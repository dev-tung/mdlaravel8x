<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Purchase;
use Illuminate\Http\JsonResponse;

class PurchaseController extends Controller
{
    /**
     * Cập nhật status hoặc payment_method
     */
    public function updateField(Request $request, $id): JsonResponse
    {
        $purchase = Purchase::find($id);
        if (!$purchase) {
            return response()->json([
                'success' => false,
                'message' => 'Phiếu nhập không tồn tại!'
            ], 404);
        }

        $purchase->{$request->field} = $request->value;
        $purchase->save();

        return response()->json([
            'success' => true,
            'message' => "Cập nhật {$request->field} thành công!",
            'purchase' => $purchase
        ]);
    }
}
