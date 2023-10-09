<?php

namespace Database\Seeders;

use App\Models\StakeHolder;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StakeHolderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        StakeHolder::factory()->count(100)->create();
    }
}
