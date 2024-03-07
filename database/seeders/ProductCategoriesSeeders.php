<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductCategoriesSeeders extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('product_categories')->insert([
            'name' => 'Food',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('product_categories')->insert([
            'name' => 'Beverages',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('product_categories')->insert([
            'name' => 'Electronics',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('product_categories')->insert([
            'name' => 'Clothings',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('product_categories')->insert([
            'name' => 'Dairy Products',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('product_categories')->insert([
            'name' => 'Cleaning supplies',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('product_categories')->insert([
            'name' => 'Personal Care',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('product_categories')->insert([
            'name' => 'Medicines',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
