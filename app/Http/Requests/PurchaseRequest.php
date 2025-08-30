<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Có thể thêm quyền nếu cần
    }

    public function rules(): array
    {
        return [
            'supplier_id' => 'required|exists:suppliers,id',
            'purchase_date' => 'required|date',
            'product_id' => 'required|array|min:1'
        ];
    }

    public function messages(): array
    {
        return [
            'supplier_id.required' => 'Vui lòng chọn nhà cung cấp.',
            'supplier_id.exists'   => 'Nhà cung cấp không hợp lệ.',
            'purchase_date.required' => 'Vui lòng nhập ngày nhập hàng.',
            'product_id.required' => 'Phiếu nhập phải có ít nhất 1 sản phẩm.'
        ];
    }
}
