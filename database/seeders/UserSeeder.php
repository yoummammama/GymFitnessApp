<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use App\Models\Admin;
use App\Models\User;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    $users = [
            [
                'user_id' => '132',
                'name' => 'Tomoa',
                'email' => 'tomoa@example.com',
                'password' => Hash::make('password123'),
              
            ],
            [
                'user_id' => '126',
                'name' => 'Alyin Yes',
                'email' => 'alvin@gymfitness.com',
                'password' => Hash::make('alvin'),
               
            ],
            [
                'user_id' => '124',
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'password' => Hash::make('user123'),
                
            ],
        ];

        foreach ($users as $userData) {
            User::firstOrCreate(
                ['email' => $userData['email']], // Prevents duplicates if you run it twice
                $userData
            );
        }

        $this->command->info('3 Users seeded successfully!');
    
    }
}
