<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CarModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('car_models')->insert([
            ['name' => 'A6', 'brand_id' => 1, 'created_at' => now()],
            ['name' => 'E60', 'brand_id' => 2, 'created_at' => now()],
            ['name' => 'W201', 'brand_id' => 3, 'created_at' => now()],
        ]);
    }
}
