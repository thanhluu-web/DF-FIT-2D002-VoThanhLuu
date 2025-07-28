<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Inventory>
 */
class InventoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $product = Product::inRandomOrder()->first();       

        return [
            'product_id' => $product->id,
            'sku' => $product->sku,
            'name' => $product->name,
            'unit' => $product->unit,
            'quantity'=> fake() -> numberBetween(50,1000),
            'status' => fake()->randomElement(['Hàng tốt','Hàng hư hỏng','Hàng chờ QA','Khác']),
            'product_type' => $product->product_type,
            'received_at' => now(),
            'manufacture_date' => fake()->dateTimeBetween('- 1 month','now') ->format('d-m-y') ,
        ];
    }
}
