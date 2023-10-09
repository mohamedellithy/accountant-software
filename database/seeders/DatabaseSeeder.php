<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\OrderItem;
use Illuminate\Database\Seeder;
use Database\Seeders\AdminSeeder;
use Database\Seeders\OrderSeeder;
use Database\Seeders\StockSeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\StakeHolderSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            // AdminSeeder::class,
            // ProductSeeder::class,
            // StakeHolderSeeder::class,
            // OrderSeeder::class,
            // OrderItemSeeder::class,
            // StockSeeder::class,
            InvoiceSeeder::class,
            InvoiceItemSeeder::class,
        ]);

    }
}
