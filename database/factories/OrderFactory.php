<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $sub_total = fake()->numberBetween(1000,10000);
        $discount  = fake()->numberBetween(0,100);
        return [
            //
            'order_number'   => fake()->unique()->numberBetween(1,100),
            'quantity'       => fake()->numberBetween(1,100),
            'sub_total'      => $sub_total,
            'total_price'    => $sub_total - $discount,
            'discount'       => $discount,
            'customer_id'    => fake()->numberBetween(1,10),
            'order_status'   => fake()->randomElement(['pending','completed','canceled','not_completed'])
        ];
    }
}
