<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\EnumOptions;

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
            'supplier_id'            => 'required|exists:suppliers,id',
            'import_date'            => 'required|date',
            'product_import_price'   => 'required|array',
            'product_import_price.*' => 'required|numeric|min:1',
            'notes'                  => 'nullable|string|max:1000',
            'status'         => 'required|in:' . implode(',', EnumOptions::importStatusKeys()),
            'payment_method' => 'required|in:' . implode(',', EnumOptions::paymentKeys()),
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
            'product_import_price.*.required' => 'Vui lòng nhập giá nhập cho tất cả sản phẩm.',
            'product_import_price.*.numeric'  => 'Giá nhập phải là số hợp lệ.',
            'product_import_price.*.min'      => 'Giá nhập phải lớn hơn 0.',
            'status.required'      => 'Vui lòng chọn trạng thái.',
            'status.in'            => 'Trạng thái không hợp lệ.',
            'payment_method.required' => 'Vui lòng chọn phương thức thanh toán.',
            'payment_method.in'       => 'Phương thức thanh toán không hợp lệ.'
        ];
    }
}
