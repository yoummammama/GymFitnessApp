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
        <div class="mx-auto max-w-6xl rounded-[2rem] border border-white/10 bg-white/5 p-8 shadow-2xl shadow-black/20 backdrop-blur-lg">
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

            @if (session('status'))
                <div class="mb-8 rounded-3xl border border-emerald-500/20 bg-emerald-500/10 p-4 text-sm text-emerald-50">{{ session('status') }}</div>
            @endif

            @if ($errors->any())
                <div class="mb-8 rounded-3xl border border-red-500/20 bg-red-500/10 p-4 text-sm text-red-100">
                    <ul class="space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid gap-10 lg:grid-cols-[1.05fr_0.95fr]">
                <section class="space-y-6">
                    <div class="rounded-[1.75rem] border border-white/10 bg-slate-950/70 p-8 shadow-xl shadow-black/20">
                        <p class="text-sm uppercase tracking-[0.35em] text-[#f97316]">Select your gym</p>
                        <h2 class="mt-3 text-2xl font-semibold text-white">Reserve a branch and time slot</h2>

                        <form method="POST" action="{{ route('booking.store') }}" class="mt-8 space-y-6">
                            @csrf

                            <label class="block text-sm font-medium text-slate-200">
                                Gym branch
                                <select name="gym_id" required class="mt-2 w-full rounded-3xl border border-white/10 bg-slate-950/70 px-4 py-3 text-white outline-none transition focus:border-[#f97316] focus:ring-2 focus:ring-[#f97316]/30">
                                    @foreach ($gyms as $gym)
                                        <option value="{{ $gym->id }}" @selected(old('gym_id') == $gym->id)>{{ $gym->name }} — {{ $gym->campus_location }}</option>
                                    @endforeach
                                </select>
                            </label>

                            <label class="block text-sm font-medium text-slate-200">
                                Workout date
                                <input type="date" name="booking_date" value="{{ old('booking_date', date('Y-m-d')) }}" required class="mt-2 w-full rounded-3xl border border-white/10 bg-slate-950/70 px-4 py-3 text-white outline-none transition focus:border-[#f97316] focus:ring-2 focus:ring-[#f97316]/30" />
                            </label>

                            <label class="block text-sm font-medium text-slate-200">
                                Time slot
                                <select name="time_slot" required class="mt-2 w-full rounded-3xl border border-white/10 bg-slate-950/70 px-4 py-3 text-white outline-none transition focus:border-[#f97316] focus:ring-2 focus:ring-[#f97316]/30">
                                    <option value="">Select a time slot</option>
                                    @foreach ($timeSlots as $slot)
                                        <option value="{{ $slot }}" @selected(old('time_slot') === $slot)>{{ $slot }}</option>
                                    @endforeach
                                </select>
                            </label>

                            <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                                <span id="statusBadge" class="inline-flex items-center justify-center rounded-full border border-white/10 bg-white/5 px-4 py-2 text-sm font-semibold uppercase tracking-[0.2em] text-slate-200">Choose a slot</span>
                                <p class="text-sm leading-6 text-slate-400">Status updates live as you choose your gym and time.</p>
                            </div>

                            <button type="submit" class="w-full rounded-3xl bg-[#f97316] px-6 py-4 text-sm font-semibold uppercase tracking-[0.18em] text-slate-950 transition hover:bg-[#fb923c]">Confirm Booking</button>
                        </form>
                    </div>
                </section>

                <section class="space-y-6">
                    <div class="rounded-[1.75rem] border border-white/10 bg-slate-950/70 p-8 shadow-xl shadow-black/20">
                        <div class="flex items-center justify-between gap-4 mb-6">
                            <div>
                                <p class="text-sm uppercase tracking-[0.35em] text-[#f97316]">My Bookings</p>
                                <h2 class="mt-2 text-2xl font-semibold text-white">Upcoming sessions</h2>
                            </div>
                        </div>

                        @if ($bookings->isEmpty())
                            <div class="rounded-[1.5rem] border border-white/10 bg-[#0f172a] p-6 text-slate-300">
                                You don’t have any bookings yet. Reserve your first session using the form on the left.
                            </div>
                        @else
                            <div class="overflow-x-auto">
                                <table class="min-w-full text-left text-sm text-slate-300">
                                    <thead class="border-b border-white/10 text-xs uppercase tracking-[0.25em] text-slate-500">
                                        <tr>
                                            <th class="px-4 py-3">Branch</th>
                                            <th class="px-4 py-3">Date</th>
                                            <th class="px-4 py-3">Time</th>
                                            <th class="px-4 py-3">Status</th>
                                            <th class="px-4 py-3">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-white/5">
                                        @foreach ($bookings as $booking)
                                            @php
                                                $status = $booking->status === 'Cancelled' ? 'Cancelled' : ($booking->booking_time->isPast() ? 'Completed' : $booking->status);
                                                $statusClass = match ($status) {
                                                    'Completed' => 'bg-slate-800 text-slate-200',
                                                    'Pending' => 'bg-yellow-500/10 text-yellow-300',
                                                    'Confirmed' => 'bg-emerald-500/10 text-emerald-300',
                                                    'Cancelled' => 'bg-red-500/10 text-red-300',
                                                    default => 'bg-white/10 text-slate-200',
                                                };
                                            @endphp
                                            <tr>
                                                <td class="px-4 py-4 text-white">{{ $booking->gym->name ?? 'Unknown' }}</td>
                                                <td class="px-4 py-4">{{ $booking->booking_time->format('M d, Y') }}</td>
                                                <td class="px-4 py-4">{{ $booking->booking_time->format('g:i A') }}</td>
                                                <td class="px-4 py-4">
                                                    <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold uppercase tracking-[0.15em] {{ $statusClass }}">{{ $status }}</span>
                                                </td>
                                                <td class="px-4 py-4 space-y-2">
                                                    @if ($status !== 'Completed' && $status !== 'Cancelled')
                                                        <a href="{{ route('booking.edit', $booking) }}" class="inline-flex rounded-full border border-white/10 bg-white/5 px-4 py-2 text-xs font-semibold uppercase tracking-[0.15em] text-white transition hover:bg-white/10">Edit</a>
                                                        <form method="POST" action="{{ route('booking.destroy', $booking) }}" class="inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="inline-flex rounded-full border border-red-500/30 bg-red-500/10 px-4 py-2 text-xs font-semibold uppercase tracking-[0.15em] text-red-300 transition hover:bg-red-500/20">Cancel</button>
                                                        </form>
                                                    @else
                                                        <span class="text-xs text-slate-400">No actions</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </section>
            </div>
        </div>
    </div>

    <script>
        const slotStatus = @json($slotStatus);
        const statusBadge = document.getElementById('statusBadge');
        const gymSelect = document.querySelector('[name="gym_id"]');
        const timeSelect = document.querySelector('[name="time_slot"]');

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

        updateStatusBadge();
    </script>
</body>
</html>
