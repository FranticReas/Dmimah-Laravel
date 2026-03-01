<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsIngredientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('product_ingredients')->insert([
            ['product_id' => 1, 'stock_id' => 9, 'quantity_reqires' => 100],
            ['product_id' => 1, 'stock_id' => 23, 'quantity_reqires' => 30],
            ['product_id' => 1, 'stock_id' => 8, 'quantity_reqires' => 150],
            ['product_id' => 1, 'stock_id' => 1,  'quantity_reqires' => 130],
            ['product_id' => 1, 'stock_id' => 21, 'quantity_reqires' => 40],
            ['product_id' => 1, 'stock_id' => 13, 'quantity_reqires' => 40],

            ['product_id' => 3, 'stock_id' => 7,  'quantity_reqires' => 400],
            ['product_id' => 3, 'stock_id' => 9, 'quantity_reqires' => 100],
            ['product_id' => 3, 'stock_id' => 1,  'quantity_reqires' => 80],
            ['product_id' => 3, 'stock_id' => 3,  'quantity_reqires' => 8],
            ['product_id' => 3, 'stock_id' => 6,  'quantity_reqires' => 2],
            ['product_id' => 3, 'stock_id' => 4,  'quantity_reqires' => 20],
            ['product_id' => 3, 'stock_id' => 10, 'quantity_reqires' => 5],
            ['product_id' => 3, 'stock_id' => 12, 'quantity_reqires' => 75],
            ['product_id' => 3, 'stock_id' => 13, 'quantity_reqires' => 75],
            ['product_id' => 3, 'stock_id' => 14, 'quantity_reqires' => 1],

            ['product_id' => 2, 'stock_id' => 5,  'quantity_reqires' => 6],
            ['product_id' => 2, 'stock_id' => 9, 'quantity_reqires' => 70],
            ['product_id' => 2, 'stock_id' => 11, 'quantity_reqires' => 10],
            ['product_id' => 2, 'stock_id' => 1,  'quantity_reqires' => 85],
            ['product_id' => 2, 'stock_id' => 4,  'quantity_reqires' => 10],
            ['product_id' => 2, 'stock_id' => 19, 'quantity_reqires' => 10],
            ['product_id' => 2, 'stock_id' => 21, 'quantity_reqires' => 1],
            ['product_id' => 2, 'stock_id' => 9, 'quantity_reqires' => 100],
            ['product_id' => 2, 'stock_id' => 20, 'quantity_reqires' => 20],
        ]);
    }
}
