<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $productId = $this->route('product');

        return [
            'taxonomy_id' => 'nullable|integer|exists:taxonomies,id',
            'name' => 'required|string|min:3|max:255',
            'slug' => "nullable|string|regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/|unique:products,slug,{$productId}",
            'sku' => "nullable|string|max:50|unique:products,sku,{$productId}",
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lte:price',
            'stock' => 'required|integer|min:0',
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string|min:5',
            'status' => 'required|in:active,inactive',
        ];
    }

    public function messages(): array
    {
        $productId = $this->route('product');

        return [
            'taxonomy_id.integer' => 'Danh mục không hợp lệ.',
            'taxonomy_id.exists' => 'Danh mục không tồn tại.',

            'name.required' => 'Tên sản phẩm là bắt buộc.',
            'name.min' => 'Tên sản phẩm phải ít nhất 3 ký tự.',
            'name.max' => 'Tên sản phẩm không được vượt quá 255 ký tự.',

            'slug.regex' => 'Slug chỉ chứa chữ thường, số và dấu gạch ngang.',
            'slug.unique' => 'Slug đã tồn tại.',

            'sku.max' => 'SKU không được vượt quá 50 ký tự.',
            'sku.unique' => 'SKU đã tồn tại.',

            'price.required' => 'Giá gốc là bắt buộc.',
            'price.numeric' => 'Giá gốc phải là số.',
            'price.min' => 'Giá gốc phải lớn hơn hoặc bằng 0.',

            'sale_price.numeric' => 'Giá khuyến mãi phải là số.',
            'sale_price.min' => 'Giá khuyến mãi phải lớn hơn hoặc bằng 0.',
            'sale_price.lte' => 'Giá khuyến mãi phải nhỏ hơn hoặc bằng giá gốc.',

            'stock.required' => 'Số lượng tồn kho là bắt buộc.',
            'stock.integer' => 'Số lượng tồn kho phải là số nguyên.',
            'stock.min' => 'Số lượng tồn kho phải lớn hơn hoặc bằng 0.',

            'short_description.max' => 'Mô tả ngắn không vượt quá 500 ký tự.',
            'description.min' => 'Mô tả chi tiết phải ít nhất 5 ký tự.',

            'status.required' => 'Trạng thái là bắt buộc.',
            'status.in' => 'Trạng thái không hợp lệ.',
        ];
    }
}
