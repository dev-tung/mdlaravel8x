<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // cho phép mọi user dùng, có thể đổi thành check quyền
    }

    public function rules(): array
    {
        return [
            'customer_id' => ['required', 'exists:customers,id'],
            'order_date' => ['required', 'date'],
            'payment_method' => ['required', 'in:cash,card,bank_transfer,online,pending'],
            'status' => ['required', 'in:pending,processing,completed,cancelled'],
            'shipping_address' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
            'product_id' => ['required', 'exists:products,id']
        ];
    }

    public function messages(): array
    {
        return [
            'customer_id.required' => 'Vui lòng chọn khách hàng.',
            'customer_id.exists'   => 'Khách hàng không tồn tại trong hệ thống.',

            'order_date.required'  => 'Ngày đặt hàng là bắt buộc.',
            'order_date.date'      => 'Ngày đặt hàng không hợp lệ.',

            'payment_method.required' => 'Vui lòng chọn phương thức thanh toán.',
            'payment_method.in'       => 'Phương thức thanh toán không hợp lệ.',

            'status.required' => 'Vui lòng chọn trạng thái đơn hàng.',
            'status.in'       => 'Trạng thái không hợp lệ.',

            'product_id.required' => 'Sản phẩm là bắt buộc.',
            'product_id.exists'   => 'Sản phẩm không tồn tại.',
        ];
    }

}
