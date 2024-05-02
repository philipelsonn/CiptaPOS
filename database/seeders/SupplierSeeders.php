<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;


class SupplierSeeders extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('suppliers')->insert([
            'company_name' => 'PT Indofood',
            'company_address' => Crypt::encryptString('Jalan Jend. Sudirman Kav. 76-78, Jakarta'),
            'pic_name' => Crypt::encryptString('Anton Nugroho'),
            'pic_phone' => Crypt::encryptString('02157958822'),
            'pic_email' => Crypt::encryptString('anton@indofood.com'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('suppliers')->insert([
            'company_name' => 'PT Nestle Indonesia',
            'company_address' => Crypt::encryptString('Jalan R.A. Kartini No. 26, Jakarta'),
            'pic_name' => Crypt::encryptString('Hendra Wijaya'),
            'pic_phone' => Crypt::encryptString('02112345678'),
            'pic_email' => Crypt::encryptString('hendra@nestle.co.id'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('suppliers')->insert([
            'company_name' => 'PT Unilever Indonesia',
            'company_address' => Crypt::encryptString('Jalan TB Simatupang Kav. 1, Jakarta'),
            'pic_name' => Crypt::encryptString('Siti Rahayu'),
            'pic_phone' => Crypt::encryptString('02187654321'),
            'pic_email' => Crypt::encryptString('siti@unilever.co.id'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('suppliers')->insert([
            'company_name' => 'PT ABC Indonesia',
            'company_address' => Crypt::encryptString('Jalan Sudirman No. 10, Jakarta'),
            'pic_name' => Crypt::encryptString('Wahyu Setiawan'),
            'pic_phone' => Crypt::encryptString('02155566677'),
            'pic_email' => Crypt::encryptString('wahyu@abc.co.id'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

    }
}
