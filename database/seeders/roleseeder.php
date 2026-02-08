<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRoleSeeder extends Seeder
{
    public function run()
    {
        // Admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Staff
        User::create([
            'name' => 'Staff',
            'email' => 'staff@example.com',
            'password' => Hash::make('password'),
            'role' => 'staff',
        ]);

        // TU
        User::create([
            'name' => 'Tata Usaha',
            'email' => 'tu@example.com',
            'password' => Hash::make('password'),
            'role' => 'tu',
        ]);

        // Pimpinan
        User::create([
            'name' => 'Pimpinan',
            'email' => 'pimpinan@example.com',
            'password' => Hash::make('password'),
            'role' => 'pimpinan',
        ]);
    }
}
