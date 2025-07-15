<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create sample regular users
        User::firstOrCreate(
            ['email' => 'john@example.com'],
            [
                'name' => 'John Doe',
                'password' => Hash::make('password123'),
                'is_banned' => false,
            ]
        );

        User::firstOrCreate(
            ['email' => 'jane@example.com'],
            [
                'name' => 'Jane Smith',
                'password' => Hash::make('password123'),
                'is_banned' => false,
            ]
        );

        User::firstOrCreate(
            ['email' => 'bob@example.com'],
            [
                'name' => 'Bob Wilson',
                'password' => Hash::make('password123'),
                'is_banned' => false,
            ]
        );

        // Create a banned user for testing
        User::firstOrCreate(
            ['email' => 'banned@example.com'],
            [
                'name' => 'Banned User',
                'password' => Hash::make('password123'),
                'is_banned' => true,
            ]
        );
    }
}
