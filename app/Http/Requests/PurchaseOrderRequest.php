<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseOrderRequest extends FormRequest
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
            'supplier_name' => 'required|exists:supplier,name',
            'order_date' => 'required|date_format:d/m/Y',
            'delivery_date' => 'required|date_format:d/m/Y|after_or_equal:order_date',

            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:product_data,sku',
            'products.*.quantity' => 'required|integer|min:1',
        ];
    }

    public function messages()
    {
        return [
            'supplier_name.required' => 'Vui lòng chọn nhà cung cấp.',
            'supplier_name.exists' => 'Nhà cung cấp không hợp lệ.',

            'order_date.required' => 'Vui lòng chọn ngày đặt hàng.',
            'order_date.date' => 'Ngày đặt hàng không hợp lệ.',

            'delivery_date.required' => 'Vui lòng chọn ngày giao hàng.',
            'delivery_date.date' => 'Ngày giao hàng không hợp lệ.',
            'delivery_date.after_or_equal' => 'Ngày giao hàng phải cùng hoặc sau ngày đặt hàng.',

            'products.required' => 'Vui lòng thêm ít nhất một sản phẩm.',
            'products.array' => 'Dữ liệu sản phẩm không đúng định dạng.',
            'products.min' => 'Vui lòng thêm ít nhất một sản phẩm.',

            'products.*.product_id.required' => 'Vui lòng nhập mã sản phẩm.',
            'products.*.product_id.exists' => 'Mã sản phẩm không tồn tại.',

            'products.*.quantity.required' => 'Vui lòng nhập số lượng.',
            'products.*.quantity.integer' => 'Số lượng phải là số nguyên.',
            'products.*.quantity.min' => 'Số lượng phải lớn hơn 0.',
        ];
    }
}
