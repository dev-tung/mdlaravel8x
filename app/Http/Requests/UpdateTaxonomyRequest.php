<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaxonomyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $taxonomyId = $this->route('taxonomy'); // id từ route

        return [
            'name' => 'required|string|min:3|max:255',
            'slug' => "nullable|string|regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/|unique:taxonomies,slug,$taxonomyId",
            'parent_id' => 'nullable|integer|exists:taxonomies,id',
            'type' => 'required|string',
            'description' => 'nullable|string|min:5|max:255',
            'status' => 'required|in:active,inactive,1,0',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên taxonomy là bắt buộc.',
            'name.min' => 'Tên taxonomy phải dài ít nhất 3 ký tự.',
            'name.max' => 'Tên taxonomy không được vượt quá 255 ký tự.',
            
            'slug.regex' => 'Slug chỉ chứa chữ thường, số và dấu gạch ngang.',
            'slug.unique' => 'Slug đã tồn tại.',

            'parent_id.integer' => 'Parent ID phải là số nguyên.',
            'parent_id.exists' => 'Parent taxonomy không tồn tại.',

            'type.required' => 'Loại taxonomy là bắt buộc.',

            'description.min' => 'Mô tả phải ít nhất 5 ký tự.',
            'description.max' => 'Mô tả không được vượt quá 255 ký tự.',

            'status.required' => 'Trạng thái là bắt buộc.',
            'status.in' => 'Trạng thái không hợp lệ.',
        ];
    }
}
