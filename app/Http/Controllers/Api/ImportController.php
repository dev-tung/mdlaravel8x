<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Import;
use Illuminate\Http\JsonResponse;

class ImportController extends Controller
{
    /**
     * Cập nhật status hoặc payment_method
     */
    public function updateField(Request $request, $id): JsonResponse
    {
        $import = Import::find($id);
        if (!$import) {
            return response()->json([
                'success' => false,
                'message' => 'Phiếu nhập không tồn tại!'
            ], 404);
        }

        $import->{$request->field} = $request->value;
        $import->save();

        return response()->json([
            'success' => true,
            'message' => "Cập nhật {$request->field} thành công!",
            'import' => $import
        ]);
    }
}
