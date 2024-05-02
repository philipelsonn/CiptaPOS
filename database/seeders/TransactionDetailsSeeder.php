<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionDetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('transaction_details')->insert([
            'transaction_header_id' => '1',
            'product_id' => '1',
            'quantity' => 3,
            'price' => 45000,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
