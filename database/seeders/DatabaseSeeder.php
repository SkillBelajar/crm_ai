<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin Seeder
        User::updateOrCreate(
            ['email' => 'admin@crm.test'],
            [
                'name' => 'Administrator MindControl',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'is_active' => true,
            ]
        );

        // User Seeder
        User::updateOrCreate(
            ['email' => 'user@crm.test'],
            [
                'name' => 'Eksekutif Negosiator',
                'password' => Hash::make('password123'),
                'role' => 'user',
                'is_active' => true,
            ]
        );
    }
}
