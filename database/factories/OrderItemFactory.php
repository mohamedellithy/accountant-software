<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItem>
 */
class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            //
            'product_id' => fake()->numberBetween(1,100),
            'qty' => fake()->numberBetween(1,100),
            'price' => fake()->numberBetween(100,10000),
            'order_id' => fake()->numberBetween(1,100)
        ];
    }
}
