<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class PaymentMethodSeeders extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('payment_methods')->insert([
            'name' => 'Cash',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('payment_methods')->insert([
            'name' => 'Card',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('payment_methods')->insert([
            'name' => 'OVO',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('payment_methods')->insert([
            'name' => 'GoPay',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('payment_methods')->insert([
            'name' => 'Dana',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('payment_methods')->insert([
            'name' => 'ShopeePay',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
