<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $imgURL = "https://picsum.photos/640/480?random=".rand();
        $imgName = 'img_'.uniqid();
        file_put_contents(public_path("profile_images/$imgName.jpg"),file_get_contents($imgURL));

        return [
            'name' => fake()->name(),
            'phone' => fake()->phoneNumber(),
            'profile_image' => $imgName.'.jpg',
            'address'=> fake()->address(),
            'role' => fake()->randomElement(['admin','staff']),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'status'=>fake()->boolean(),
            'remember_token' => Str::random(10)
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
