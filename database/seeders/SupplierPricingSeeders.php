<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class SupplierPricingSeeders extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('supplier_pricings')->insert([
            'product_id' => '1',
            'supplier_id' => '1',
            'price' => 5000,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('supplier_pricings')->insert([
            'product_id' => '2',
            'supplier_id' => '2',
            'price' => 10000,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('supplier_pricings')->insert([
            'product_id' => '3',
            'supplier_id' => '3',
            'price' => 18000,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

    }
}
