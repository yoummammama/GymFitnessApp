<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (range(1, 10) as $index) {
            $letter = chr(64 + $index); 
            $email = 'user' . strtolower($letter) . '@example.com';

            // Use firstOrCreate to prevent "Duplicate Entry" errors
            User::firstOrCreate(
                ['email' => $email], // Search criteria
                [
                    'user_id'       => 100 + $index, 
                    'name'          => 'User ' . $letter,
                    'password'      => Hash::make('password123'),
                    'last_login_at' => now(),
                ]
            );
        }

        $this->command->info('8 Random users seeded successfully!');
    }
}