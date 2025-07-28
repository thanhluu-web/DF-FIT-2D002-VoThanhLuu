<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
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
            'phone' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'status' => 'required|in:0,1',
        ];
    }

    public function messages(): array
{
    return [
        'name.required' => 'Tên không được để trống.',
        'name.string' => 'Tên phải là chuỗi ký tự.',
        'name.max' => 'Tên không được vượt quá 255 ký tự.',

        'phone.required' => 'Số điện thoại không được để trống.',
        'phone.string' => 'Số điện thoại phải là chuỗi ký tự.',
        'phone.max' => 'Số điện thoại không được vượt quá 255 ký tự.',

        'address.required' => 'Địa chỉ không được để trống.',
        'address.string' => 'Địa chỉ phải là chuỗi ký tự.',
        'address.max' => 'Địa chỉ không được vượt quá 255 ký tự.',

        'status.required' => 'Trạng thái không được để trống.',
        'status.in' => 'Trạng thái không hợp lệ, chỉ nhận giá trị 0 hoặc 1.',
    ];
}
}
