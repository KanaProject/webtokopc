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
            'name'     => 'Admin TechnoStore',
            'email'    => 'admin@technostore.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
            'phone'    => '081200000001',
            'address'  => 'Jl. Sudirman No.1, Jakarta Pusat',
        ]);

        // Sample customer
        User::create([
            'name'     => 'Budi Santoso',
            'email'    => 'budi@example.com',
            'password' => Hash::make('password'),
            'role'     => 'customer',
            'phone'    => '081234567890',
            'address'  => 'Jl. Gatot Subroto No.10, Jakarta Selatan',
        ]);
    }
}
