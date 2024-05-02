<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class TransactionHeadersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('transaction_headers')->insert([
            'payment_method_id' => 2,
            'cashier_id' => 1,
            'card_number' => Crypt::encryptString('1111 2222 3333 4444'),
            'transaction_date' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
