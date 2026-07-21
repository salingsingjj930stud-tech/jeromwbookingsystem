<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name'     => 'Admin',
            'email'    => 'admin@noir.com',
            'password' => Hash::make('admin123'),
            'role'     => 'admin',
        ]);

        // Customer
        User::create([
            'name'     => 'Customer',
            'email'    => 'customer@noir.com',
            'password' => Hash::make('customer123'),
            'role'     => 'customer',
        ]);
    }
}