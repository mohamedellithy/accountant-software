<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class PurchasingInvoiceFactory extends Factory
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
            'total_price'    => $sub_total,
            'supplier_id'    => fake()->numberBetween(1,10)
        ];
    }
}
