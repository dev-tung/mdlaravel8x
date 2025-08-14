<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('id');

        return [
            'category_id'       => 'required|exists:category,id',
            'name'              => 'required|string|min:3|max:255',
            'slug'              => "required|string|alpha_dash|unique:product,slug,{$id}",
            'sku'               => 'nullable|string|max:20',
            'price'             => 'required|numeric|min:0',
            'sale_price'        => 'nullable|numeric|min:0',
            'stock'             => 'required|integer|min:0',
            'short_description' => 'nullable|string|max:255',
            'description'       => 'nullable|string',
            'status'            => 'required|boolean',
        ];
    }
}
