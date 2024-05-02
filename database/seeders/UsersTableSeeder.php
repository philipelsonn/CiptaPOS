<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // DB::table('users')->truncate();
        DB::table('users')->insert([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'email_verified_at' => now(),
            'phone_number' => Crypt::encryptString('123456789'),
            'type' => 'employee',
            'avatar' => 'image/default-male.png',
            'salary' => Crypt::encryptString('500000'),
            'password' => Hash::make('Testing12345'),
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'name' => 'Administration',
            'email' => 'john12345@example.com',
            'email_verified_at' => now(),
            'phone_number' => Crypt::encryptString('123456789'),
            'type' => 'admin',
            'avatar' => 'image/default-male.png',
            'salary' => Crypt::encryptString('5000000'),
            'password' => Hash::make('Password12345'),
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
