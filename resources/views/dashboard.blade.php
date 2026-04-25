<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard -  GYM and Fitness</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#020617] text-white">
    <div class="min-h-screen bg-[radial-gradient(circle_at_top,_rgba(245,75,66,0.18),_transparent_20%),radial-gradient(circle_at_bottom_right,_rgba(14,165,233,0.12),_transparent_35%)] px-6 py-8 sm:px-10">
        <div class="mx-auto max-w-4xl rounded-[2rem] border border-white/10 bg-white/5 p-8 shadow-2xl shadow-black/20 backdrop-blur-lg">
            <header class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between mb-10">
                <div>
                    <p class="text-sm uppercase tracking-[0.35em] text-[#f97316]"> GYM and Fitness</p>
                    <h1 class="mt-3 text-3xl font-semibold text-white sm:text-4xl">HELLO, {{ Auth::user()->name }}.</h1>
                    {{-- CO2 #3: Read intentional session data stored on login --}}
                    <div class="mt-2 flex flex-wrap items-center gap-3">
                        @if (session('user_last_login'))
                            <span class="inline-flex items-center gap-1.5 rounded-full border border-white/10 bg-white/5 px-3 py-1 text-xs text-slate-300">
                                <svg class="h-3 w-3 text-[#f97316]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Last login: {{ \Carbon\Carbon::parse(session('user_last_login'))->format('d M Y, h:i A') }}
                            </span>
                        @endif
                        @if (session('user_role'))
                            <span class="inline-flex items-center rounded-full border border-[#f97316]/30 bg-[#f97316]/10 px-3 py-1 text-xs font-semibold uppercase tracking-[0.15em] text-[#f97316]">
                                {{ session('user_role') }}
                            </span>
                        @endif
                    </div>
                </div>
                 @can('access-admin')
                 <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="rounded-full bg-[#f97316] px-6 py-3 text-sm font-semibold uppercase tracking-[0.2em] text-slate-950 transition hover:bg-[#fb923c]">Sign Out</button>
                    </form> 
                 @else
                 <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                    <a href="{{ route('booking.index') }}" class="inline-flex items-center justify-center rounded-full border border-white/20 bg-white/5 px-6 py-3 text-sm uppercase tracking-[0.15em] text-white transition hover:bg-white/10">Book a Session</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="rounded-full bg-[#f97316] px-6 py-3 text-sm font-semibold uppercase tracking-[0.2em] text-slate-950 transition hover:bg-[#fb923c]">Sign Out</button>
                    </form>
                </div>
                 @endcan
                
            </header>

            @if (session('status'))
                <div class="mb-8 rounded-3xl border border-emerald-500/20 bg-emerald-500/10 p-4 text-sm text-emerald-50">{{ session('status') }}</div>
            @endif

            <div class="grid gap-6 lg:grid-cols-3">
                <div class="rounded-[1.5rem] border border-white/10 bg-slate-950/60 p-6">
                    <p class="text-sm uppercase tracking-[0.35em] text-[#f97316]">Membership</p>
                    <p class="mt-4 text-lg font-semibold text-white">24/7 Gym Access</p>
                    <p class="mt-3 text-sm leading-6 text-slate-300">Stay on track with round-the-clock access, flexible hours, and premium equipment.</p>
                </div>
                <div class="rounded-[1.5rem] border border-white/10 bg-slate-950/60 p-6">
                    <p class="text-sm uppercase tracking-[0.35em] text-[#f97316]">Support</p>
                    <p class="mt-4 text-lg font-semibold text-white">Personal Training</p>
                    <p class="mt-3 text-sm leading-6 text-slate-300">Connect with expert trainers to build a fresh plan tailored to your goals.</p>
                </div>
                <div class="rounded-[1.5rem] border border-white/10 bg-slate-950/60 p-6">
                    <p class="text-sm uppercase tracking-[0.35em] text-[#f97316]">Community</p>
                    <p class="mt-4 text-lg font-semibold text-white">Group Classes</p>
                    <p class="mt-3 text-sm leading-6 text-slate-300">Join high-energy classes that keep your workouts fun and motivating.</p>
                </div>
            </div>

            <section class="mt-10 rounded-[1.75rem] border border-white/10 bg-slate-950/70 p-8 shadow-xl shadow-black/20">
                @can('access-admin')
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between mb-6">
                        <div>
                            <p class="text-sm uppercase tracking-[0.35em] text-[#f97316]">All Bookings</p>
                            <h2 class="mt-2 text-2xl font-semibold text-white">Manage all user bookings</h2>
                        </div>
                        <a href="{{ route('admin.gyms.index') }}" class="inline-flex items-center justify-center rounded-full border border-white/20 bg-white/5 px-6 py-3 text-sm uppercase tracking-[0.15em] text-white transition hover:bg-white/10">Manage Gyms</a>
                    </div>

                    @if (isset($bookings) && $bookings->isNotEmpty())
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-left text-sm text-slate-300">
                                <thead class="border-b border-white/10 text-xs uppercase tracking-[0.25em] text-slate-500">
                                    <tr>
                                        <th class="px-4 py-3">User ID</th>
                                        <th class="px-4 py-3">Gym</th>
                                        <th class="px-4 py-3">Date</th>
                                        <th class="px-4 py-3">Status</th>
                                        <th class="px-4 py-3">Action</th>
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
                                            <td class="px-4 py-4 text-white">{{$booking->user->user_id ?? 'Unknown' }}</td>
                                            <td class="px-4 py-4 text-white">{{ $booking->gym->name ?? 'Unknown' }}</td>
                                            <td class="px-4 py-4">{{ $booking->booking_time->format('M d, Y g:i A') }}</td>
                                            <td class="px-4 py-4">
                                                <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold uppercase tracking-[0.15em] {{ $statusClass }}">{{ $status }}</span>
                                            </td>
                                            @if($booking->status !== 'Cancelled' )
                                            <td class="px-4 py-4">
                                                <a href="{{ route('booking.edit', $booking->id) }}" class="inline-flex items-center justify-center rounded-full border border-white/20 bg-white/5 px-4 py-2 text-xs uppercase tracking-[0.15em] text-white transition hover:bg-white/10">Edit</a>
                                            </td>
                                            @endif
                                            @if($booking->status === 'Cancelled' )
                                            <td class="px-4 py-4">
                                                <p class="inline-flex items-center justify-center rounded-full border border-white/20 bg-white/5 px-4 py-2 text-xs uppercase tracking-[0.15em] text-white transition hover:bg-white/10">No Action</p>
                                            </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="rounded-[1.5rem] border border-white/10 bg-[#0f172a] p-6 text-slate-300">
                            No bookings found in the system.
                        </div>
                    @endcan
                @else
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between mb-6">
                        <div>
                            <p class="text-sm uppercase tracking-[0.35em] text-[#f97316]">Booked Sessions</p>
                            <h2 class="mt-2 text-2xl font-semibold text-white">Your upcoming bookings</h2>
                        </div>
                        <a href="{{ route('booking.index') }}" class="inline-flex items-center justify-center rounded-full border border-white/20 bg-white/5 px-5 py-3 text-sm uppercase tracking-[0.15em] text-white transition hover:bg-white/10">Manage bookings</a>
                    </div>

                    @if (isset($bookings) && $bookings->isNotEmpty())
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-left text-sm text-slate-300">
                                <thead class="border-b border-white/10 text-xs uppercase tracking-[0.25em] text-slate-500">
                                    <tr>
                                        <th class="px-4 py-3">Branch</th>
                                        <th class="px-4 py-3">Date</th>
                                        <th class="px-4 py-3">Time</th>
                                        <th class="px-4 py-3">Status</th>
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
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="rounded-[1.5rem] border border-white/10 bg-[#0f172a] p-6 text-slate-300">
                            You don't have any upcoming sessions booked yet. Tap "Book a Session" to reserve your next workout.
                        </div>
                    @endif
                @endcan
            </section>
        </div>
    </div>
</body>
</html>