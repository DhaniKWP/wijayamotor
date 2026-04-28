<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ADMIN
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'phone' => '081234567890',
            'address' => 'Admin Address',
            'role' => 'admin'
        ]);

        // MEKANIK
        User::create([
            'name' => 'Mekanik',
            'email' => 'mekanik@gmail.com',
            'password' => Hash::make('password'),
            'phone' => '081234567891',
            'address' => 'Workshop',
            'role' => 'mekanik'
        ]);

        // CUSTOMER
        User::create([
            'name' => 'Customer',
            'email' => 'user@gmail.com',
            'password' => Hash::make('password'),
            'phone' => '081234567892',
            'address' => 'Customer Address',
            'role' => 'customer'
        ]);
    }
}