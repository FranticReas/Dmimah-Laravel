<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('stocks')->insert([
            ['name' => 'Gula Pasir', 'quantity' => 335, 'price' => 18500, 'unit' => 1000, 'measurement_unit' => 'gram'],
            ['name' => 'Mentega', 'quantity' => 500, 'price' => 70000, 'unit' => 500, 'measurement_unit' => 'gram'],
            ['name' => 'Yeast', 'quantity' => 468, 'price' => 55000, 'unit' => 500, 'measurement_unit' => 'gram'],
            ['name' => 'Susu Bubuk Dancow', 'quantity' => 310, 'price' => 65000, 'unit' => 400, 'measurement_unit' => 'gram'],
            ['name' => 'Telur', 'quantity' => 10, 'price' => 30000, 'unit' => 16, 'measurement_unit' => 'pcs'],
            ['name' => 'Bread Improver', 'quantity' => 492, 'price' => 55000, 'unit' => 500, 'measurement_unit' => 'gram'],
            ['name' => 'Terigu Protein Tinggi', 'quantity' => 4200, 'price' => 88000, 'unit' => 5000, 'measurement_unit' => 'gram'],
            ['name' => 'Dark Cooking Chocolate', 'quantity' => 700, 'price' => 67500, 'unit' => 1000, 'measurement_unit' => 'gram'],
            ['name' => 'Terigu Protein Sedang', 'quantity' => 530, 'price' => 13500, 'unit' => 1000, 'measurement_unit' => 'gram'],
            ['name' => 'Garam Tefina', 'quantity' => 10, 'price' => 500, 'unit' => 250, 'measurement_unit' => 'gram'],
            ['name' => 'Maizena', 'quantity' => 240, 'price' => 6500, 'unit' => 250, 'measurement_unit' => 'gram'],
            ['name' => 'Susu UHT', 'quantity' => 175, 'price' => 7000, 'unit' => 250, 'measurement_unit' => 'ml'],
            ['name' => 'Margarin Palmia Royal', 'quantity' => 110, 'price' => 9300, 'unit' => 200, 'measurement_unit' => 'gram'],
            ['name' => 'Dus Donat Mimah', 'quantity' => 5, 'price' => 2190, 'unit' => 1, 'measurement_unit' => 'pcs'],
            ['name' => 'Glaze Coklat', 'quantity' => 998, 'price' => 70000, 'unit' => 1000, 'measurement_unit' => 'gram'],
            ['name' => 'Glaze Putih', 'quantity' => 999, 'price' => 60000, 'unit' => 1000, 'measurement_unit' => 'gram'],
            ['name' => 'Meisis Tulip', 'quantity' => 1000, 'price' => 22500, 'unit' => 250, 'measurement_unit' => 'gram'],
            ['name' => 'Minyak Padat', 'quantity' => 1000, 'price' => 35000, 'unit' => 1000, 'measurement_unit' => 'gram'],
            ['name' => 'SP', 'quantity' => 60, 'price' => 14500, 'unit' => 70, 'measurement_unit' => 'gram'],
            ['name' => 'Vanili Bubuk', 'quantity' => 19, 'price' => 30000, 'unit' => 40, 'measurement_unit' => 'gram'],
            ['name' => 'Minyak Goreng Sunco', 'quantity' => 1899, 'price' => 42000, 'unit' => 2000, 'measurement_unit' => 'ml'],
            ['name' => 'Selai Strawberi', 'quantity' => 300, 'price' => 24500, 'unit' => 500, 'measurement_unit' => 'gram'],
            ['name' => 'Coklat Bubuk Van Houten', 'quantity' => 5, 'price' => 40000, 'unit' => 65, 'measurement_unit' => 'gram'],
            ['name' => 'Kacang Oven', 'quantity' => 249, 'price' => 17500, 'unit' => 250, 'measurement_unit' => 'gram'],
            ['name' => 'Almond', 'quantity' => 249, 'price' => 50000, 'unit' => 250, 'measurement_unit' => 'gram']
        ]);
    }
}
