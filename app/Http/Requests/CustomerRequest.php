<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|min:3|max:255',
            'email' => 'nullable|email|unique:customers,email',
            'phone' => 'nullable|string|max:50',
            'password' => 'nullable|string|min:6|max:255',
            'address' => 'nullable|string|max:500',
            'taxonomy_id' => 'nullable|integer|exists:taxonomies,id'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên khách hàng là bắt buộc.',
            'name.min' => 'Tên khách hàng ít nhất 3 ký tự.',
            'name.max' => 'Tên khách hàng không vượt quá 255 ký tự.',
            'email.email' => 'Email không hợp lệ.',
            'email.unique' => 'Email đã tồn tại.',
            'phone.max' => 'Số điện thoại không vượt quá 50 ký tự.',
            'password.min' => 'Mật khẩu ít nhất 6 ký tự.',
            'password.max' => 'Mật khẩu không vượt quá 255 ký tự.',
            'address.max' => 'Địa chỉ không vượt quá 500 ký tự.',
            'taxonomy_id.integer' => 'Nhóm khách hàng không hợp lệ.',
            'taxonomy_id.exists' => 'Nhóm khách hàng không tồn tại.'
        ];
    }
}
