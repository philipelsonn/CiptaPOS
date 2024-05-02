<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UsersTableSeeder::class);
        $this->call(PaymentMethodSeeders:: class);
        $this->call(ProductCategoriesSeeders::class);
        $this->call(SupplierSeeders::class);
        $this->call(ProductSeeders::class);
        $this->call(SupplierPricingSeeders::class);
        $this->call([
            TransactionHeadersSeeder::class,
            TransactionDetailsSeeder::class,
        ]);
    }
}
