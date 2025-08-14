<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id'       => 'required',
            'name'              => 'required',
            'slug'              => 'required',
            'sku'               => 'nullable',
            'price'             => 'required',
            'sale_price'        => 'nullable',
            'stock'             => 'required',
            'short_description' => 'nullable',
            'description'       => 'nullable',
            'status'            => 'required'
        ];
    }
}
