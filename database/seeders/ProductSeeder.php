<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            [
                'name' => 'Brownies',
                'price' => 60000
            ],
            [
                'name' => 'Roll Cake',
                'price' => 60000
            ],
            [
                'name' => 'Donuts',
                'price' => 60000
            ],
        ]);
    }
}
