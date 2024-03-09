<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeders extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            [
                'name' => 'Indomie',
                'price' => 10000,
                'description' => 'Indomie goreng',
                'image' => 'productImage/Indomie.jpg',
                'category_id' => 1,
                'stock' => 20,
                'discount' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Air Mineral Nestle (600 mL)',
                'price' => 15000,
                'description' => 'Air mineral Pure Life botol isi 600mL',
                'image' => 'productImage/Nestle_Air_Mineral.jpg',
                'category_id' => 2,
                'stock' => 100,
                'discount' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sunlight',
                'price' => 20000,
                'description' => 'Sunlight',
                'image' => 'productImage/sunlight.jpg',
                'category_id' => 6,
                'stock' => 15,
                'discount' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
