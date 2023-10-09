<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Stock>
 */
class StockFactory extends Factory
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
            'product_id'      => fake()->numberBetween(1,100),
            'quantity'        => fake()->numberBetween(1,100),
            'purchasing_price'=> fake()->numberBetween(10,1000),
            'sale_price'      => fake()->numberBetween(100,10000),
            'supplier_id' => 1
        ];
    }
}
