<?php

namespace App\Http\Requests;

use App\Models\Inbound\GoodsReceipt;
use App\Models\Inbound\PurchaseOrderDetail;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class GoodsReceiptRequest extends FormRequest
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
            'PO' => 'required|exists:purchase_order,purchase_order_id',
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:product_data,id',
            'products.*.quantity' => 'required|integer',
        ];
    }

    public function messages(): array
    {
        return [
            'PO.required' => 'Vui lòng chọn đơn đặt hàng.',
            'PO.exists' => 'Đơn đặt hàng không tồn tại.',

            'products.required' => 'Vui lòng nhập ít nhất một sản phẩm.',
            'products.array' => 'Danh sách sản phẩm không hợp lệ.',
            'products.min' => 'Phải có ít nhất một sản phẩm.',

            'products.*.product_id.required' => 'Vui lòng chọn sản phẩm.',
            'products.*.product_id.exists' => 'Sản phẩm không tồn tại trong hệ thống.',

            'products.*.quantity.required' => 'Vui lòng nhập số lượng.',
            'products.*.quantity.integer' => 'Số lượng phải là số nguyên.',
            // 'products.*.quantity.min' => 'Số lượng phải lớn hơn 0.',
        ];
    }

    public function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            $purchaseOrderID = $this->input('PO');
            $products = $this->input('products', []);

            $poDetails = PurchaseOrderDetail::where('purchase_order_id', $purchaseOrderID)->get()->keyBy('product_id');
            $createdQuantity = GoodsReceipt::where('purchase_order_id', $purchaseOrderID)
                ->where('status','!=','Hủy')
                ->get()
                ->groupBy('product_id')
                ->map(fn($items) => $items->sum('quantity'));

            foreach ($products as $index => $item) {
                $productId = $item['product_id'] ?? null;
                $qtyNew = (int) $item['quantity'];
                $qtyOrdered = $poDetails[$productId]->qty_ordered ?? 0;
                $qtyCreated = $createdQuantity[$productId] ?? 0;
                $qtyRemaining = $qtyOrdered - $qtyCreated;

     
                if ($qtyNew > $qtyRemaining) {
                    $validator->errors()->add(
                        "products.$index.quantity",
                        "Sản phẩm vượt quá số lượng cho phép,Vui lòng nhập số lượng nhỏ hơn hoặc bằng: $qtyRemaining"
                    );
                }
            }
        });
    }
}
