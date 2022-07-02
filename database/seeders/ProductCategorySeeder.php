<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('product_categories')->insert([
            ['name' => 'motor', 'created_at' => now()],
            ['name' => 'kocnice', 'created_at' => now()],
            ['name' => 'auspuh', 'created_at' => now()],
        ]);
    }
}
