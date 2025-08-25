<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExpenseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'taxonomy_id' => 'nullable|integer|exists:taxonomies,id',
            'name' => 'required|string|min:3|max:255',
            'amount' => 'required|numeric|min:0',
            'expense_date' => 'nullable|date',
            'note' => 'nullable|string|max:500'
        ];
    }

    public function messages(): array
    {
        return [
            'taxonomy_id.integer' => 'Loại chi phí không hợp lệ.',
            'taxonomy_id.exists' => 'Loại chi phí không tồn tại.',

            'name.required' => 'Tên chi phí là bắt buộc.',
            'name.min' => 'Tên chi phí phải ít nhất 3 ký tự.',
            'name.max' => 'Tên chi phí không được vượt quá 255 ký tự.',

            'amount.required' => 'Số tiền là bắt buộc.',
            'amount.numeric' => 'Số tiền phải là số.',
            'amount.min' => 'Số tiền phải lớn hơn hoặc bằng 0.',

            'expense_date.date' => 'Ngày chi không hợp lệ.',
            'note.max' => 'Ghi chú không được vượt quá 500 ký tự.',
        ];
    }
}
