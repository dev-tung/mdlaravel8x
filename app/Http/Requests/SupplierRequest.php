<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplierRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|min:3|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên nhà cung cấp là bắt buộc.',
            'name.min' => 'Tên nhà cung cấp phải ít nhất 3 ký tự.',
            'name.max' => 'Tên nhà cung cấp không được vượt quá 255 ký tự.',

            'phone.max' => 'Số điện thoại không được vượt quá 20 ký tự.',

            'email.email' => 'Email không hợp lệ.',
            'email.max' => 'Email không được vượt quá 255 ký tự.',

            'address.max' => 'Địa chỉ không được vượt quá 500 ký tự.',
        ];
    }
}
