<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@pizzashop.com',
            'phone' => '1234567890',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // Create regular user
        User::create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'user@pizzashop.com',
            'phone' => '9876543210',
            'password' => Hash::make('user123'),
            'role' => 'user',
        ]);
    }
}
