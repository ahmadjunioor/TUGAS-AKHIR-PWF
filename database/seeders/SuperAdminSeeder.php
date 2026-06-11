<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'superadmin@bantuin.com'],
            [
                'name' => 'Super Administrator',
                'password' => Hash::make('password123'),
                'role' => 'superadmin',
                'balance' => 0
            ]
        );
    }
}
