<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Gym;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('email', '!=', 'admin@gymfitness.com')->take(10)->get();
        if ($users->count() < 5) {
            $this->command->warn('BookingSeeder requires at least 5 non-admin users.');
            return;
        }

        $gym = Gym::where('name', 'BHUB')->first();
        if (!$gym) {
            $this->command->warn('BookingSeeder requires the BHUB gym to exist.');
            return;
        }
        $scenarios = [
        1 => 10, // Day 1: 10 users
        2 => 8,  // Day 2: 8 users
        ];

        
        $timeSlot = '8:00 AM - 10:00 AM';
        $startTime = explode(' - ', $timeSlot)[0];
        

        $bookingCount = 0;

        foreach ($scenarios as $daysToAdd => $userCount){
            $date = Carbon::now()->addDays($daysToAdd)->format('Y-m-d');
            $bookingTime = Carbon::createFromFormat('Y-m-d g:i A', "$date $startTime");

            $users = User::where('email', '!=', 'admin@gymfitness.com')
                ->take($userCount)
                ->get();
                
            foreach ($users as $user) {
            Booking::firstOrCreate(
                [
                    'user_id' => $user->user_id,
                    'booking_time' => $bookingTime,
                ],
                [
                    'gym_id' => $gym->id,
                    'status' => 'Confirmed',
                ]
            );

            $bookingCount++;
        }
        }

        $this->command->info("{$bookingCount} bookings seeded successfully for the same gym, date, and time slot!");
    }
}
