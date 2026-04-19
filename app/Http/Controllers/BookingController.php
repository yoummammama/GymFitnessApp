<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Gym;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index()
    {
        $gyms = Gym::all();

        if ($gyms->isEmpty()) {
            $gyms = collect([
                Gym::create([
                    'name' => 'BHUB',
                    'campus_location' => 'Sg.Long',
                    'max_capacity' => 40,
                ]),
                Gym::create([
                    'name' => 'Batuu',
                    'campus_location' => 'Kampar',
                    'max_capacity' => 35,
                ]),
            ]);
        }

        $timeSlots = [
            '8:00 AM - 10:00 AM',
            '10:00 AM - 12:00 PM',
            '12:00 PM - 2:00 PM',
            '2:00 PM - 4:00 PM',
            '4:00 PM - 6:00 PM',
        ];

        $slotStatus = [];
        foreach ($gyms as $gym) {
            $slotStatus[$gym->id] = [
                '8:00 AM - 10:00 AM' => 'Available',
                '10:00 AM - 12:00 PM' => 'Almost Full',
                '12:00 PM - 2:00 PM' => 'Fully Booked',
                '2:00 PM - 4:00 PM' => 'Almost Full',
                '4:00 PM - 6:00 PM' => 'Available',
            ];
        }

        $bookings = Auth::user()->bookings()->with('gym')->orderBy('booking_time')->get();

        return view('booking', compact('gyms', 'timeSlots', 'slotStatus', 'bookings'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'gym_id' => ['required', 'exists:gyms,id'],
            'booking_date' => ['required', 'date', 'after_or_equal:today'],
            'time_slot' => ['required', 'string', 'in:8:00 AM - 10:00 AM,10:00 AM - 12:00 PM,12:00 PM - 2:00 PM,2:00 PM - 4:00 PM,4:00 PM - 6:00 PM'],
        ]);

        $startTime = explode(' - ', $validated['time_slot'])[0];
        $bookingTime = Carbon::createFromFormat('Y-m-d g:i A', $validated['booking_date'] . ' ' . $startTime);

        Booking::create([
            'student_id' => Auth::id(),
            'gym_id' => $validated['gym_id'],
            'booking_time' => $bookingTime,
            'status' => 'Confirmed',
        ]);

        return back()->with('status', 'Your booking is confirmed and added to My Bookings.');
    }

    public function edit(Booking $booking)
    {
        if ($booking->student_id !== Auth::id()) {
            abort(403);
        }

        $gyms = Gym::all();
        $timeSlots = [
            '8:00 AM - 10:00 AM',
            '10:00 AM - 12:00 PM',
            '12:00 PM - 2:00 PM',
            '2:00 PM - 4:00 PM',
            '4:00 PM - 6:00 PM',
        ];

        return view('booking-edit', compact('booking', 'gyms', 'timeSlots'));
    }

    public function update(Request $request, Booking $booking)
    {
        if ($booking->student_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'gym_id' => ['required', 'exists:gyms,id'],
            'booking_date' => ['required', 'date', 'after_or_equal:today'],
            'time_slot' => ['required', 'string', 'in:8:00 AM - 10:00 AM,10:00 AM - 12:00 PM,12:00 PM - 2:00 PM,2:00 PM - 4:00 PM,4:00 PM - 6:00 PM'],
        ]);

        $startTime = explode(' - ', $validated['time_slot'])[0];
        $bookingTime = Carbon::createFromFormat('Y-m-d g:i A', $validated['booking_date'] . ' ' . $startTime);

        $booking->update([
            'gym_id' => $validated['gym_id'],
            'booking_time' => $bookingTime,
            'status' => 'Confirmed',
        ]);

        return redirect()->route('booking.index')->with('status', 'Booking updated successfully.');
    }

    public function destroy(Booking $booking)
    {
        if ($booking->student_id !== Auth::id()) {
            abort(403);
        }

        $booking->update(['status' => 'Cancelled']);

        return redirect()->route('booking.index')->with('status', 'Booking has been cancelled.');
    }
}
