<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            [
                'name' => 'Ovo je motor',
                'price' => 43,
                'min_applicable_year' => 1987,
                'max_applicable_year' => 2022,
                'model_id' => 1,
                'category_id' => 1,
                'created_at' => now(),
            ],
            [
                'name' => 'Ovo su kocnice',
                'price' => 56,
                'min_applicable_year' => 1999,
                'max_applicable_year' => 2003,
                'model_id' => 2,
                'category_id' => 2,
                'created_at' => now()],
            [
                'name' => 'Ovo je auspuh',
                'price' => 433,
                'min_applicable_year' => 2001,
                'max_applicable_year' => 2012,
                'model_id' => 3,
                'category_id' => 3,
                'created_at' => now()],
        ]);
    }
}
