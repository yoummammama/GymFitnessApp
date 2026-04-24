<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Gym;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminBookingController extends Controller
{
    /**
     * Display admin dashboard with all bookings
     */
    public function dashboard()
    {
        $bookings = Booking::with(['user', 'gym'])
            ->orderBy('booking_time', 'desc')
            ->get();

        $gyms = Gym::all();
        
        // Calculate statistics
        $stats = [
            'total' => $bookings->count(),
            'pending' => $bookings->where('status', 'Pending')->count(),
            'confirmed' => $bookings->where('status', 'Confirmed')->count(),
            'cancelled' => $bookings->where('status', 'Cancelled')->count(),
        ];

        return view('dashboard', compact('bookings', 'gyms', 'stats'));
    }

    /**
     * Update booking status or booking time (Admin only)
     */
    public function update(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'status' => ['required', 'string', 'in:Pending,Confirmed,Cancelled'],
            'booking_date' => ['required', 'date'],
            'time_slot' => ['required', 'string', 'in:8:00 AM - 10:00 AM,10:00 AM - 12:00 PM,12:00 PM - 2:00 PM,2:00 PM - 4:00 PM,4:00 PM - 6:00 PM'],
        ]);

        $startTime = explode(' - ', $validated['time_slot'])[0];
        $bookingTime = \Carbon\Carbon::createFromFormat('Y-m-d g:i A', $validated['booking_date'] . ' ' . $startTime);

        $booking->update([
            'status' => $validated['status'],
            'booking_time' => $bookingTime,
        ]);

        return redirect()->route('admin.dashboard')->with('status', 'Booking updated successfully.');
    }

    /**
     * Cancel a booking (Admin only)
     */
    public function destroy(Booking $booking)
    {
        $booking->delete();

        return redirect()->route('admin.dashboard')->with('status', 'Booking deleted successfully.');
    }
}