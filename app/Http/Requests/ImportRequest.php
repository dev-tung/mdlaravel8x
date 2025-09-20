<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImportRequest extends FormRequest
{
    /**
     * Xác định user có quyền gửi request này không
     */
    public function authorize(): bool
    {
        return true; // cho phép tất cả, có thể tùy biến quyền
    }

    /**
     * Các rule để validate dữ liệu
     */
    public function rules(): array
    {
        return [
            'supplier_id'         => 'required|exists:suppliers,id',
            'import_date'         => 'required|date',
            'total_import_amount' => 'required|numeric|min:0',
            'notes'               => 'nullable|string|max:1000',
            'status'              => 'required|in:pending,completed,cancelled',
            'payment_method'      => 'required|in:cash,bank_transfer,credit'
        ];
    }

    /**
     * Thông báo lỗi tùy chỉnh
     */
    public function messages(): array
    {
        return [
            'supplier_id.required' => 'Vui lòng chọn nhà cung cấp.',
            'supplier_id.exists'   => 'Nhà cung cấp không tồn tại.',
            'import_date.required' => 'Ngày nhập là bắt buộc.',
            'import_date.date'     => 'Ngày nhập không đúng định dạng.',
            'total_import_amount.required' => 'Tổng tiền nhập là bắt buộc.',
            'total_import_amount.numeric'  => 'Tổng tiền nhập phải là số.',
            'status.required'      => 'Vui lòng chọn trạng thái.',
            'status.in'            => 'Trạng thái không hợp lệ.',
            'payment_method.required' => 'Vui lòng chọn phương thức thanh toán.',
            'payment_method.in'       => 'Phương thức thanh toán không hợp lệ.'
        ];
    }
}
