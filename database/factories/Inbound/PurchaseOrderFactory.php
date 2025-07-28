<?php

namespace Database\Factories\Inbound;

use App\Models\Inbound\PurchaseOrder;
use App\Models\Inbound\PurchaseOrderDetail;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Inbound\PurchaseOrder>
 */
class PurchaseOrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'purchase_order_id' => 'PO'.fake()->unique()->numerify('#####'),
            'supplier_id' => Supplier::inRandomOrder()->first()->id,
            'PO_date' => fake()->dateTimeBetween('-1 month', 'now'),
            'status' => fake()->randomElement(['Mới', 'Đang nhập hàng', 'Hoàn thành', 'Hủy']),
        ];
    }

        public function addItemToPO($count = 5){

            return $this->afterCreating(function (PurchaseOrder $PO) use ($count) {
                $products = Product::inRandomOrder()->take($count)->get();

                foreach ($products as $product) {
                    $qtyOrdered = rand(10, 500);
                    $qtyReceived = rand(0, $qtyOrdered);

                    PurchaseOrderDetail::create([
                        'purchase_order_id' => $PO->purchase_order_id,
                        'product_id' => $product->id,
                        'qty_ordered' => $qtyOrdered,
                        'qty_received' => $qtyReceived,
                        'qty_pending' => $qtyOrdered - $qtyReceived,
                    ]);
                }
    });}
}
