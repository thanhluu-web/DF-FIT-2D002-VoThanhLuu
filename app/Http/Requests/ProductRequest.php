<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'  => 'required|string|max:255',
            'unit' => 'required',
            'product_type' => 'required',
            'status' => 'required|in:0,1',
            'image' => 'required'
        ];
    }

    public function messages(): array
{
    return [
        'name.required' => 'Tên sản phẩm không được để trống.',
        'name.string' => 'Tên sản phẩm phải là chuỗi ký tự.',
        'name.max' => 'Tên sản phẩm không được vượt quá 255 ký tự.',
        'unit.required' => 'Đơn vị tính không được để trống.',
        'product_type.required' => 'Loại sản phẩm không được để trống.',
        'status.required' => 'Trạng thái không được để trống.',
        'status.in' => 'Trạng thái không hợp lệ, chỉ nhận giá trị 0 hoặc 1.',
        'image.required' => 'Ảnh sản phẩm không được để trống.',
    ];
}
}
