<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'        => ['required', 'string', 'max:255'],
            'quantity'    => ['required', 'integer', 'min:0'],
            'taxonomy_id' => ['required', 'exists:taxonomies,id'],
            'import_price'  => ['required', 'numeric', 'min:0'],
            'supplier_id' => ['nullable', 'exists:suppliers,id'],
            'price_input' => ['nullable', 'numeric', 'min:0'],
            'price_output'=> ['nullable', 'numeric', 'min:0'],
            'unit'        => ['nullable', 'string', 'max:50'],
            'thumbnail'   => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif', 'max:2048'],
            'description' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'        => 'Tên sản phẩm là bắt buộc.',
            'import_price.required' => 'Giá nhập là bắt buộc.',
            'quantity.required'    => 'Số lượng là bắt buộc.',
            'taxonomy_id.required' => 'Danh mục sản phẩm là bắt buộc.',
            'taxonomy_id.exists'   => 'Danh mục không hợp lệ.',
            'supplier_id.exists'   => 'Nhà cung cấp không hợp lệ.',
            'thumbnail.image'      => 'Ảnh sản phẩm phải là định dạng hình ảnh.',
            'thumbnail.mimes'      => 'Ảnh chỉ chấp nhận jpg, jpeg, png, gif.',
            'thumbnail.max'        => 'Ảnh sản phẩm tối đa 2MB.',
        ];
    }
}
