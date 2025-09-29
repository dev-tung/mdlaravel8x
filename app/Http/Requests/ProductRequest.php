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
            'name'              => ['required', 'string', 'max:255'],
            'short_description' => ['nullable', 'string', 'max:500'],
            'description'       => ['nullable', 'string'],

            'taxonomy_id' => ['required', 'exists:taxonomies,id'],
            'supplier_id' => ['nullable', 'exists:suppliers,id'],
            'unit'        => ['nullable', 'string', 'max:50'],

            'thumbnail'   => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif', 'max:2048'],

            // validate variants là một mảng
            'variants'                 => ['nullable', 'array'],
            'variants.*.size'          => ['nullable', 'string', 'max:100'],
            'variants.*.color'         => ['nullable', 'string', 'max:100'],
            'variants.*.price_sale'    => ['required_with:variants', 'numeric', 'min:0'],
            'variants.*.quantity'      => ['required_with:variants', 'integer', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'              => 'Tên sản phẩm là bắt buộc.',
            'short_description.max'      => 'Mô tả ngắn tối đa 500 ký tự.',

            'taxonomy_id.required'       => 'Danh mục sản phẩm là bắt buộc.',
            'taxonomy_id.exists'         => 'Danh mục không hợp lệ.',
            'supplier_id.exists'         => 'Nhà cung cấp không hợp lệ.',

            'thumbnail.image'            => 'Ảnh sản phẩm phải là định dạng hình ảnh.',
            'thumbnail.mimes'            => 'Ảnh chỉ chấp nhận jpg, jpeg, png, gif.',
            'thumbnail.max'              => 'Ảnh sản phẩm tối đa 2MB.',

            'variants.array'             => 'Danh sách biến thể không hợp lệ.',
            'variants.*.price_sale.required_with' => 'Giá bán là bắt buộc khi có biến thể.',
            'variants.*.price_sale.numeric'       => 'Giá bán phải là số.',
            'variants.*.price_sale.min'           => 'Giá bán phải lớn hơn hoặc bằng 0.',
            'variants.*.quantity.required_with'   => 'Số lượng là bắt buộc khi có biến thể.',
            'variants.*.quantity.integer'         => 'Số lượng phải là số nguyên.',
            'variants.*.quantity.min'             => 'Số lượng phải lớn hơn hoặc bằng 0.',
            'variants.*.size.max'                 => 'Size tối đa 100 ký tự.',
            'variants.*.color.max'                => 'Màu sắc tối đa 100 ký tự.',
        ];
    }

}
