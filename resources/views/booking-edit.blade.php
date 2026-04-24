<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Booking - GYM and Fitness</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#020617] text-white antialiased">
    <div class="min-h-screen bg-[radial-gradient(circle_at_top,_rgba(245,75,66,0.18),_transparent_20%),radial-gradient(circle_at_bottom_right,_rgba(14,165,233,0.12),_transparent_35%)] px-6 py-8 sm:px-10">
        <div class="mx-auto max-w-4xl rounded-[2rem] border border-white/10 bg-white/5 p-8 shadow-2xl shadow-black/20 backdrop-blur-lg">
            <header class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between mb-10">
                <div>
                    <p class="text-sm uppercase tracking-[0.35em] text-[#f97316]">GYM and Fitness</p>
                    <h1 class="mt-3 text-3xl font-semibold text-white sm:text-4xl">Edit booking</h1>
                </div>
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                    <a href="{{ route('booking.index') }}" class="inline-flex items-center justify-center rounded-full border border-white/20 bg-white/5 px-6 py-3 text-sm uppercase tracking-[0.15em] text-white transition hover:bg-white/10">Back to Bookings</a>
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center rounded-full bg-[#f97316] px-6 py-3 text-sm font-semibold uppercase tracking-[0.15em] text-slate-950 transition hover:bg-[#fb923c]">Dashboard</a>
                </div>
            </header>

            <div class="rounded-[1.75rem] border border-white/10 bg-slate-950/70 p-8 shadow-xl shadow-black/20">
                <form method="POST" action="{{ route('booking.update', $booking) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid gap-6 lg:grid-cols-2">
                        <label class="block text-sm font-medium text-slate-200">
                            Gym branch
                            <select name="gym_id" required class="mt-2 w-full rounded-3xl border border-white/10 bg-slate-950/70 px-4 py-3 text-white outline-none transition focus:border-[#f97316] focus:ring-2 focus:ring-[#f97316]/30">
                                @foreach ($gyms as $gym)
                                    <option value="{{ $gym->id }}" @selected(old('gym_id', $booking->gym_id) == $gym->id)>{{ $gym->name }} — {{ $gym->campus_location }}</option>
                                @endforeach
                            </select>
                        </label>

                        <label class="block text-sm font-medium text-slate-200">
                            Workout date
                            <input type="date" name="booking_date" value="{{ old('booking_date', $booking->booking_time->format('Y-m-d')) }}" required class="mt-2 w-full rounded-3xl border border-white/10 bg-slate-950/70 px-4 py-3 text-white outline-none transition focus:border-[#f97316] focus:ring-2 focus:ring-[#f97316]/30" />
                        </label>
                    </div>

                    <label class="block text-sm font-medium text-slate-200">
                        Time slot
                        <select name="time_slot" required class="mt-2 w-full rounded-3xl border border-white/10 bg-slate-950/70 px-4 py-3 text-white outline-none transition focus:border-[#f97316] focus:ring-2 focus:ring-[#f97316]/30">
                            @foreach ($timeSlots as $slot)
                                <option value="{{ $slot }}" @selected(old('time_slot', $booking->booking_time->format('g:i A') . ' - ' . $booking->booking_time->copy()->addHours(2)->format('g:i A')) === $slot)>{{ $slot }}</option>
                            @endforeach
                        </select>
                    </label>

                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                        <button type="submit" class="rounded-3xl bg-[#f97316] px-6 py-4 text-sm font-semibold uppercase tracking-[0.18em] text-slate-950 transition hover:bg-[#fb923c]">Save Changes</button>

                    </div>
                </form>
                <div class="mt-6 border-t border-white/10 pt-6">
                                            <form method="POST" action="{{ route('booking.destroy', $booking) }}" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="rounded-3xl border border-red-500/30 bg-red-500/10 px-6 py-4 text-sm font-semibold uppercase tracking-[0.18em] text-red-300 transition hover:bg-red-500/20">Cancel Booking</button>
                        </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
