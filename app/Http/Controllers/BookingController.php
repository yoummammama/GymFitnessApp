<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Gym;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\UpdateBookingRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    private $timeSlots = [
        '8:00 AM - 10:00 AM',
        '10:00 AM - 12:00 PM',
        '12:00 PM - 2:00 PM',
        '2:00 PM - 4:00 PM',
        '4:00 PM - 6:00 PM',
    ];

    /**
     * Compute slot availability dynamically from real database data
     */
    private function computeSlotStatus($gyms, $date = null)
    {
        $date = $date ?? now()->format('Y-m-d');
        $slotStatus = [];

        foreach ($gyms as $gym) {
            $slotStatus[$gym->id] = [];
            foreach ($this->timeSlots as $slot) {
                // Parse the slot time
                $startTime = explode(' - ', $slot)[0];
                $bookingTime = Carbon::createFromFormat('Y-m-d g:i A', $date . ' ' . $startTime);

                // Count active bookings for this gym, date, and time slot
                $bookingCount = Booking::where('gym_id', $gym->id)
                    ->where('status', '!=', 'Cancelled')
                    ->whereBetween('booking_time', [
                        $bookingTime->copy(),
                        $bookingTime->copy()->addHours(2)->subMinute()
                    ])
                    ->count();

                // Determine availability based on capacity safely
                $capacity = (int) $gym->max_capacity;
                $percentFull = $capacity > 0 ? ($bookingCount / $capacity) * 100 : 100; // Assume full if capacity is 0

                if ($percentFull >= 100) {
                    $slotStatus[$gym->id][$slot] = 'Fully Booked';
                } elseif ($percentFull >= 75) {
                    $slotStatus[$gym->id][$slot] = 'Almost Full';
                } else {
                    $slotStatus[$gym->id][$slot] = 'Available';
                }
            }
        }

        return $slotStatus;
    }

    public function index(Request $request)
    {
        $gyms = Gym::all();
        $slotStatus = $this->computeSlotStatus($gyms);
        
        // Get filter parameters from the request
        $gymFilter = $request->get('gym_id');
        $statusFilter = $request->get('status');
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');
        $searchEmail = $request->get('search_email');

        // Start with user's bookings
        $query = Booking::with('gym', 'user')
            ->where('user_id', Auth::user()->user_id);

        // Apply filters
        if ($gymFilter) {
            $query->byGym($gymFilter);
        }
        if ($statusFilter) {
            $query->byStatus($statusFilter);
        }
        if ($dateFrom && $dateTo) {
            $query->byDateRange($dateFrom . ' 00:00:00', $dateTo . ' 23:59:59');
        }
        
        // Apply email filter (Fixed missing implementation)
        if ($searchEmail) {
            $query->whereHas('user', function ($q) use ($searchEmail) {
                $q->where('email', 'like', '%' . $searchEmail . '%');
            });
        }

        $bookings = $query->orderBy('booking_time', 'desc')->get();
        $timeSlots = $this->timeSlots;

        return view('booking', compact('gyms', 'slotStatus', 'bookings', 'gymFilter', 'statusFilter', 'dateFrom', 'dateTo', 'searchEmail', 'timeSlots'));
    }

    public function store(StoreBookingRequest $request)
    {
        $validated = $request->validated();

        // Check if slot is fully booked
        $gym = Gym::findOrFail($validated['gym_id']);
        $slotStatus = $this->computeSlotStatus([$gym], $validated['booking_date']);
        
        if ($slotStatus[$gym->id][$validated['time_slot']] === 'Fully Booked') {
            return back()->withInput()->withErrors(['time_slot' => 'This time slot is fully booked. Please choose another time.']);
        }

        // Check for duplicate bookings
        $startTime = explode(' - ', $validated['time_slot'])[0];
        $bookingTime = Carbon::createFromFormat('Y-m-d g:i A', $validated['booking_date'] . ' ' . $startTime);

        $existingBooking = Booking::where('user_id', Auth::user()->user_id)
            ->where('gym_id', $validated['gym_id'])
            ->where('booking_time', $bookingTime)
            ->where('status', '!=', 'Cancelled')
            ->first();

        if ($existingBooking) {
            return back()->withInput()->withErrors(['time_slot' => 'You already have a booking for this gym at this time.']);
        }

        $booking = Booking::create([
            'user_id' => Auth::user()->user_id,
            'gym_id' => $validated['gym_id'],
            'booking_time' => $bookingTime,
            'status' => 'Confirmed',
        ]);

// Track booked gyms in session safely without using push()
        $bookedGyms = $request->session()->get('booked_gyms', []); // Get existing array or default to empty
        $bookedGyms[] = [
            'gym_id' => $gym->id,
            'gym_name' => $gym->name,
            'booking_date' => $validated['booking_date'],
        ];
        $request->session()->put('booked_gyms', $bookedGyms); // Save it back to the session

        // Set flash message with booking details
        return back()
            ->with('status', "Your booking for {$gym->name} on {$validated['booking_date']} at {$validated['time_slot']} has been confirmed!")
            ->with('booking_id', $booking->id);
    }

    /**
     * Show a single booking detail
     */
    public function show(Booking $booking)
    {
        $this->authorize('view', $booking);

        // Store in cookie for tracking recently viewed bookings
        $recentlyViewed = json_decode(request()->cookie('recently_viewed_bookings', '[]'), true);
        if (!in_array($booking->id, $recentlyViewed)) {
            $recentlyViewed[] = $booking->id;
            // Keep only last 10
            if (count($recentlyViewed) > 10) {
                array_shift($recentlyViewed);
            }
        }

        // Fixed: Attach cookie to a response() object instead of directly to view()
        return response()
            ->view('booking-show', compact('booking'))
            ->cookie('recently_viewed_bookings', json_encode($recentlyViewed), 60 * 24 * 30); // 30 days
    }

    public function edit(Booking $booking)
    {
        $this->authorize('update', $booking);

        $gyms = Gym::all();
        $date = $booking->booking_time->format('Y-m-d');
        $slotStatus = $this->computeSlotStatus($gyms, $date);
        $timeSlots = $this->timeSlots;

        return view('booking-edit', compact('booking', 'gyms', 'slotStatus', 'timeSlots'));
    }

    public function update(UpdateBookingRequest $request, Booking $booking)
    {
        $this->authorize('update', $booking);

        $validated = $request->validated();

        // Check if slot is fully booked
        $gym = Gym::findOrFail($validated['gym_id']);
        $slotStatus = $this->computeSlotStatus([$gym], $validated['booking_date']);
        
        if ($slotStatus[$gym->id][$validated['time_slot']] === 'Fully Booked') {
            return back()->withInput()->withErrors(['time_slot' => 'This time slot is fully booked. Please choose another time.']);
        }

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
        $this->authorize('delete', $booking);

        $booking->delete();

        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard')->with('status', 'Booking has been deleted.');
        }

        return redirect()->route('booking.index')->with('status', 'Booking has been deleted.');
    }
}