<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GymSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $gyms = [
            [
                'name' => 'BHUB',
                'campus_location' => 'Sg.Long',
                'max_capacity' => 40,
            ],
            [
                'name' => 'Batuu',
                'campus_location' => 'Kampar',
                'max_capacity' => 35,
            ],
        ];

        foreach ($gyms as $gym) {
            \App\Models\Gym::firstOrCreate(
                ['name' => $gym['name'], 'campus_location' => $gym['campus_location']],
                ['max_capacity' => $gym['max_capacity']]
            );
        }

        $this->command->info('Gyms seeded successfully!');
    }
}
