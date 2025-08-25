<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Http\JsonResponse;

class OrderApiController extends Controller
{
    /**
     * Cập nhật status hoặc payment_method
     */
    public function updateField(Request $request, $id): JsonResponse
    {
        $order = Order::find($id);
        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Đơn hàng không tồn tại!'
            ], 404);
        }

        $order->{$request->field} = $request->value;
        $order->save();

        return response()->json([
            'success' => true,
            'message' => "Cập nhật {$request->field} thành công!",
            'order' => $order
        ]);
    }
}
