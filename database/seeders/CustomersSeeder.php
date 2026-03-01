<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('customers')->insert([
            ['name' => 'John Doe',
            'phone_number' => '1234567890',
            'address' => '123 Main St, Anytown, USA',
            'description' => 'Customer description goes here'],
            ['name' => 'Jane Smith',
            'phone_number' => '0987654321',
            'address' => '456 Elm St, Othertown, USA',
            'description' => 'Customer description goes here'],
            ['name' => 'Bob Johnson',
            'phone_number' => '5555555555',
            'address' => '789 Oak St, Somewhere, USA',
            'description' => 'Customer description goes here']
        ]);
    }
}
