<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize()
    {
        // Đặt thành true nếu bạn không dùng quyền (policy)
        return true;
    }

    public function rules()
    {
        return [
            'category_id' => 'required',
            'name' => 'required',
            'slug' => 'required',
            'sku' => 'nullable',
            'price' => 'required',
            'sale_price' => 'nullable',
            'stock' => 'required',
            'short_description' => 'nullable',
            'description' => 'nullable',
            'status' => 'nullable',
            'image' => 'nullable', // max 2MB
        ];
    }

    public function messages()
    {
        return [
            // 'category_id.required' => 'Bạn chưa chọn danh mục sản phẩm.',
            // 'category_id.exists' => 'Danh mục sản phẩm không hợp lệ.',
            // 'name.required' => 'Tên sản phẩm là bắt buộc.',
            // 'slug.required' => 'Slug là bắt buộc.',
            // 'slug.unique' => 'Slug đã tồn tại.',
            // 'price.required' => 'Giá gốc là bắt buộc.',
            // 'price.min' => 'Giá gốc không được nhỏ hơn 0.',
            // 'sale_price.lte' => 'Giá khuyến mãi phải nhỏ hơn hoặc bằng giá gốc.',
            // 'stock.required' => 'Số lượng tồn kho là bắt buộc.',
            // 'image.image' => 'Ảnh phải là file ảnh hợp lệ.',
            // 'image.max' => 'Ảnh không được vượt quá 2MB.',
        ];
    }
}
