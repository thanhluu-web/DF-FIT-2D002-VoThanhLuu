<?php

namespace Database\Factories;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $imgURL = "https://picsum.photos/640/480?random=".rand();
        $imgName = 'img_'.uniqid();
        file_put_contents(public_path("product_images/$imgName.jpg"),file_get_contents($imgURL));

        return [
            'name' => fake()->name(),
            'image' => $imgName.'.jpg',
            'sku'=> strtoupper(fake()->unique()->bothify('???#####')),
            'unit' => fake()->randomElement(['Cái','Hộp','Thùng']),
            'status'=>fake()->boolean(),
            'product_type'=>fake()->randomElement(['Sở hữu','Ký gửi']),
            'shelf_life' => fake()-> randomElement([365,240,90,730]),
        ];
    }
}
