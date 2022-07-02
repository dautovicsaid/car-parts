<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('brands')->insert([
            ['name' => 'Audi', 'created_at' => now()],
            ['name' => 'BMW', 'created_at' => now()],
            ['name' => 'Mercedes', 'created_at' => now()],
        ]);
    }
}
