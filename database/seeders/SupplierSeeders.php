<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
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
            'company_address' => 'Jalan Jend. Sudirman Kav. 76-78, Jakarta',
            'pic_name' => 'Anton Nugroho',
            'pic_phone' => '02157958822',
            'pic_email' => 'anton@indofood.com',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('suppliers')->insert([
            'company_name' => 'PT Nestle Indonesia',
            'company_address' => 'Jalan R.A. Kartini No. 26, Jakarta',
            'pic_name' => 'Hendra Wijaya',
            'pic_phone' => '02112345678',
            'pic_email' => 'hendra@nestle.co.id',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('suppliers')->insert([
            'company_name' => 'PT Unilever Indonesia',
            'company_address' => 'Jalan TB Simatupang Kav. 1, Jakarta',
            'pic_name' => 'Siti Rahayu',
            'pic_phone' => '02187654321',
            'pic_email' => 'siti@unilever.co.id',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('suppliers')->insert([
            'company_name' => 'PT ABC Indonesia',
            'company_address' => 'Jalan Sudirman No. 10, Jakarta',
            'pic_name' => 'Wahyu Setiawan',
            'pic_phone' => '02155566677',
            'pic_email' => 'wahyu@abc.co.id',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

    }
}
