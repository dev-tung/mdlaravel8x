<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Export;
use Illuminate\Http\JsonResponse;

class ExportController extends Controller
{
    /**
     * Cập nhật status hoặc payment_method
     */
    public function updateField(Request $request, $id): JsonResponse
    {
        $export = Export::find($id);
        if (!$export) {
            return response()->json([
                'success' => false,
                'message' => 'Đơn hàng không tồn tại!'
            ], 404);
        }

        $export->{$request->field} = $request->value;
        $export->save();

        return response()->json([
            'success' => true,
            'message' => "Cập nhật {$request->field} thành công!",
            'export' => $export
        ]);
    }
}
