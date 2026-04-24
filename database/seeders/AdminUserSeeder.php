<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Find or create an admin user by email
        $user = User::firstOrCreate(
            ['email' => 'admin@gymfitness.com'],
            [
                'name' => 'System Admin',
                'user_id' => '122',
                'password' => Hash::make('admin123'),
            ]
        );

        // Create or update the admin record
        Admin::firstOrCreate(
            ['user_id' => $user->user_id],
            [
                'employee_id' => 'EMP001',
                'access_level' => 'super_admin',
            ]
        );

        $this->command->info('Admin user created successfully!');
        $this->command->info('Email: admin@gymfitness.com');
        $this->command->info('Password: admin123');
    }
}