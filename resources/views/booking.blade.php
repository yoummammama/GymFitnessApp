<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Book a Session - GYM and Fitness</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#020617] text-white antialiased">
    <div class="min-h-screen bg-[radial-gradient(circle_at_top,_rgba(245,75,66,0.18),_transparent_20%),radial-gradient(circle_at_bottom_right,_rgba(14,165,233,0.12),_transparent_35%)] px-6 py-8 sm:px-10">
        <div class="mx-auto max-w-7xl rounded-[2rem] border border-white/10 bg-white/5 p-8 shadow-2xl shadow-black/20 backdrop-blur-lg">
            
            <header class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between mb-10">
                <div>
                    <p class="text-sm uppercase tracking-[0.35em] text-[#f97316]"> GYM and Fitness</p>
                    <h1 class="mt-3 text-3xl font-semibold text-white sm:text-4xl">Book your workout session</h1>
                </div>
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center rounded-full border border-white/20 bg-white/5 px-6 py-3 text-sm uppercase tracking-[0.15em] text-white transition hover:bg-white/10">Back to Dashboard</a>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="inline-flex items-center justify-center rounded-full bg-[#f97316] px-6 py-3 text-sm font-semibold uppercase tracking-[0.15em] text-slate-950 transition hover:bg-[#fb923c]">Sign Out</a>
                    <form id="logout-form" method="POST" action="{{ route('logout') }}" class="hidden">@csrf</form>
                </div>
            </header>

            {{-- Main Two-Column Grid --}}
            <div class="grid gap-8 lg:grid-cols-[1fr_300px]">
                
                {{-- LEFT COLUMN: Booking Actions & History --}}
                <div class="space-y-8">
                    
                    {{-- Reserve Section --}}
                    <section class="rounded-[1.75rem] border border-white/10 bg-slate-950/70 p-8 shadow-xl shadow-black/20">
                        <p class="text-sm uppercase tracking-[0.35em] text-[#f97316]">Select your gym</p>
                        <h2 class="mt-3 text-2xl font-semibold text-white">Reserve a branch and time slot</h2>

                        <form method="POST" action="{{ route('booking.store') }}" class="mt-8 grid gap-6 md:grid-cols-2">
                            @csrf
                            <div class="space-y-6">
                                <label class="block text-sm font-medium text-slate-200">
                                    Gym branch
                                    <select name="gym_id" required class="mt-2 w-full rounded-3xl border border-white/10 bg-slate-950/70 px-4 py-3 text-white outline-none transition focus:border-[#f97316] focus:ring-2 focus:ring-[#f97316]/30">
                                        @foreach ($gyms as $gym)
                                            <option value="{{ $gym->id }}" @selected(old('gym_id', request('gym_id', $selectedGymId)) == $gym->id)>{{ $gym->name }} — {{ $gym->campus_location }}</option>
                                        @endforeach
                                    </select>
                                </label>

                                <label class="block text-sm font-medium text-slate-200">
                                    Workout date
                                    <input type="date" id="booking-date" name="booking_date" value="{{ old('booking_date', $selectedDate ?? date('Y-m-d')) }}" min="{{ date('Y-m-d') }}" required class="mt-2 w-full rounded-3xl border border-white/10 bg-slate-950/70 px-4 py-3 text-white outline-none transition focus:border-[#f97316] focus:ring-2 focus:ring-[#f97316]/30" />
                                </label>
                            </div>

                            <div class="space-y-6">
                                <label class="block text-sm font-medium text-slate-200">
                                    Time slot
                                    <select name="time_slot" id="time-slot" required class="mt-2 w-full rounded-3xl border border-white/10 bg-slate-950/70 px-4 py-3 text-white outline-none transition focus:border-[#f97316] focus:ring-2 focus:ring-[#f97316]/30">
                                        <option value="">Select a time slot</option>
                                        @foreach ($timeSlots as $slot)
                                            <option value="{{ $slot }}" @selected(old('time_slot', request('time_slot')) === $slot)>{{ $slot }}</option>
                                        @endforeach
                                    </select>
                                </label>

                                <div class="flex flex-col gap-3">
                                    <span id="statusBadge" class="inline-flex items-center justify-center rounded-full border border-white/10 bg-white/5 px-4 py-2 text-sm font-semibold uppercase tracking-[0.2em] text-slate-200">Choose a slot</span>
                                    <button type="submit" class="w-full rounded-3xl bg-[#f97316] px-6 py-4 text-sm font-semibold uppercase tracking-[0.18em] text-slate-950 transition hover:bg-[#fb923c]">Confirm Booking</button>
                                </div>
                            </div>
                        </form>
                    </section>

                    {{-- Upcoming Sessions Section --}}
                    <section class="rounded-[1.75rem] border border-white/10 bg-slate-950/70 p-8 shadow-xl shadow-black/20">
                        <div class="flex flex-col gap-6 md:flex-row md:items-end md:justify-between mb-8">
                            <div>
                                <p class="text-sm uppercase tracking-[0.35em] text-[#f97316]">My Bookings</p>
                                <h2 class="mt-2 text-2xl font-semibold text-white">Upcoming sessions</h2>
                            </div>
                            
                            <form method="GET" action="{{ route('booking.index') }}" class="flex flex-wrap gap-3">
                                <select name="gym_id" class="rounded-2xl border border-white/10 bg-slate-900 px-4 py-2 text-xs text-white outline-none focus:border-[#f97316]">
                                    <option value="">All Gyms</option>
                                    @foreach ($gyms as $gym)
                                        <option value="{{ $gym->id }}" @selected($gymFilter == $gym->id)>{{ $gym->name }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="rounded-full bg-white/10 px-4 py-2 text-xs font-semibold uppercase text-white hover:bg-white/20">Filter</button>
                            </form>
                        </div>

                        @if ($bookings->isEmpty())
                            <div class="rounded-2xl border border-white/5 bg-white/5 p-6 text-center text-slate-400">
                                No sessions found.
                            </div>
                        @else
                            <div class="overflow-x-auto">
                                <table class="w-full text-left text-sm text-slate-300">
                                    <thead class="border-b border-white/10 text-xs uppercase tracking-widest text-slate-500">
                                        <tr>
                                            <th class="px-4 py-4">Branch</th>
                                            <th class="px-4 py-4">Date</th>
                                            <th class="px-4 py-4">Time</th>
                                            <th class="px-4 py-4">Status</th>
                                            <th class="px-4 py-4 text-right">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-white/5">
                                        @foreach ($bookings as $booking)
                                            @php
                                                $status = $booking->status === 'Cancelled' ? 'Cancelled' : ($booking->booking_time->isPast() ? 'Completed' : $booking->status);
                                                $statusClass = match ($status) {
                                                    'Completed' => 'bg-slate-800 text-slate-400',
                                                    'Pending' => 'bg-yellow-500/10 text-yellow-300',
                                                    'Confirmed' => 'bg-emerald-500/10 text-emerald-300',
                                                    'Cancelled' => 'bg-red-500/10 text-red-300',
                                                    default => 'bg-white/10 text-slate-200',
                                                };
                                            @endphp
                                            <tr class="group hover:bg-white/[0.02] transition cursor-pointer">
                                                <td class="px-4 py-4 font-medium text-white"><a href="{{ route('booking.show', $booking->id) }}" class="hover:text-[#f97316] transition">{{ $booking->gym->name ?? 'Unknown' }}</a></td>
                                                <td class="px-4 py-4"><a href="{{ route('booking.show', $booking->id) }}" class="hover:text-[#f97316] transition">{{ $booking->booking_time->format('M d') }}</a></td>
                                                <td class="px-4 py-4"><a href="{{ route('booking.show', $booking->id) }}" class="hover:text-[#f97316] transition">{{ $booking->booking_time->format('g:i A') }}</a></td>
                                                <td class="px-4 py-4">
                                                    <span class="rounded-full px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wider {{ $statusClass }}">{{ $status }}</span>
                                                </td>
                                                <td class="px-4 py-4 text-right">
                                                    @if ($status !== 'Completed' && $status !== 'Cancelled')
                                                        <form method="POST" action="{{ route('booking.destroy', $booking) }}" class="inline">
                                                            @csrf @method('DELETE')
                                                            <button class="text-xs uppercase tracking-widest text-red-400 hover:text-red-300">Cancel</button>
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </section>
                </div>

                {{-- RIGHT COLUMN: Sidebar (Recent Activity) --}}
                <aside class="space-y-6">
                    <div class="sticky top-8">
                        <div class="mb-4 flex items-center justify-between px-2">
                            <h3 class="text-xs uppercase tracking-[0.25em] text-[#f97316] font-bold">Recent Activity</h3>
                            <div class="h-px flex-1 bg-white/10 ml-4"></div>
                        </div>

                        @if($recentlyViewedBookings->isEmpty())
                            <p class="px-2 text-xs text-slate-500 italic">No recent views.</p>
                        @else
                            <div class="space-y-3">
                                @foreach($recentlyViewedBookings as $recent)
                                    <a href="{{ route('booking.show', $recent->id) }}" class="block group rounded-2xl border border-white/5 bg-slate-900/50 p-4 transition hover:border-[#f97316]/50 hover:bg-slate-900">
                                        <div class="flex flex-col">
                                            <span class="text-[10px] uppercase tracking-widest text-slate-500 group-hover:text-[#f97316] transition">Viewed Session</span>
                                            <span class="mt-1 font-semibold text-white">{{ $recent->gym->name ?? 'Unknown' }}</span>
                                            <div class="mt-2 flex items-center justify-between text-xs text-slate-400">
                                                <span>{{ $recent->booking_time->format('M d, Y') }}</span>
                                                <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 transition text-[#f97316]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                </svg>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        @endif

                        <div class="mt-8 rounded-2xl bg-gradient-to-br from-[#f97316]/10 to-transparent p-6 border border-[#f97316]/20">
                            <p class="text-xs font-bold uppercase tracking-widest text-[#f97316]">Pro Tip</p>
                            <p class="mt-2 text-sm text-slate-300 leading-relaxed">Book at least 24 hours in advance to guarantee your preferred equipment is available.</p>
                        </div>
                    </div>
                </aside>

            </div> {{-- End Grid --}}
        </div>
    </div>

    {{-- Script remains same as original logic --}}
    <script>
        const slotStatus = @json($slotStatus);
        const statusBadge = document.getElementById('statusBadge');
        const gymSelect = document.querySelector('[name="gym_id"]');
        const timeSelect = document.querySelector('[name="time_slot"]');
        const dateInput = document.getElementById('booking-date');

        const badgeClasses = {
            Available: 'border-emerald-500/30 bg-emerald-500/10 text-emerald-300',
            'Almost Full': 'border-amber-400/30 bg-amber-500/10 text-amber-300',
            'Fully Booked': 'border-red-500/30 bg-red-500/10 text-red-300',
            Default: 'border-white/10 bg-white/5 text-slate-200',
        };

        function updateStatusBadge() {
            const gymId = gymSelect.value;
            const slot = timeSelect.value;
            const label = slotStatus[gymId]?.[slot] || 'Choose a slot';
            statusBadge.textContent = label;
            statusBadge.className = 'inline-flex items-center justify-center rounded-full border px-4 py-2 text-sm font-semibold uppercase tracking-[0.2em] ' + (badgeClasses[label] ?? badgeClasses.Default);
        }

        gymSelect.addEventListener('change', updateStatusBadge);
        timeSelect.addEventListener('change', updateStatusBadge);
        dateInput.addEventListener('change', () => {
            const params = new URLSearchParams(window.location.search);
            params.set('booking_date', dateInput.value);
            window.location.search = params.toString();
        });
        updateStatusBadge();
    </script>
</body>
</html>