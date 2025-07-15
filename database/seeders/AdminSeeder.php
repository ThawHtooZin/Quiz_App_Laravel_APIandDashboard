<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::firstOrCreate(
            ['email' => 'admin@quizapp.com'],
            [
                'name' => 'Admin',
                'password' => bcrypt('quizappadmin123'),
                'is_banned' => false,
            ]
        );
    }
}
