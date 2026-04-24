@extends('layouts.app')

@section('content')
<div class="px-6 py-8 sm:px-10">
    <div class="mx-auto max-w-2xl">
        <div class="rounded-[2rem] border border-white/10 bg-white/5 p-8 shadow-2xl shadow-black/20 backdrop-blur-lg">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-3xl font-semibold text-white">Booking Details</h2>
                <a href="{{ route('booking.index') }}" class="text-[#f97316] hover:text-[#fb923c]">← Back</a>
            </div>

            <div class="space-y-6">
                <div class="border-l-4 border-[#f97316] pl-4">
                    <p class="text-sm text-slate-400">Booking ID</p>
                    <p class="text-lg font-semibold text-white">{{ $booking->id }}</p>
                </div>

                <div class="border-l-4 border-[#f97316] pl-4">
                    <p class="text-sm text-slate-400">Gym</p>
                    <p class="text-lg font-semibold text-white">{{ $booking->gym->name }}</p>
                    <p class="text-sm text-slate-300">{{ $booking->gym->campus_location }}</p>
                </div>

                <div class="border-l-4 border-[#f97316] pl-4">
                    <p class="text-sm text-slate-400">Member</p>
                    <p class="text-lg font-semibold text-white">{{ $booking->user->name }}</p>
                    <p class="text-sm text-slate-300">{{ $booking->user->email }}</p>
                </div>

                <div class="border-l-4 border-[#f97316] pl-4">
                    <p class="text-sm text-slate-400">Booking Date & Time</p>
                    <p class="text-lg font-semibold text-white">{{ $booking->booking_time->format('M d, Y \a\t h:i A') }}</p>
                </div>

                <div class="border-l-4 border-[#f97316] pl-4">
                    <p class="text-sm text-slate-400">Status</p>
                    <div class="mt-2">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium @if($booking->status === 'Confirmed') bg-emerald-500/20 text-emerald-50 @elseif($booking->status === 'Pending') bg-yellow-500/20 text-yellow-50 @else bg-red-500/20 text-red-50 @endif">
                            {{ $booking->status }}
                        </span>
                    </div>
                </div>

                <div class="border-l-4 border-[#f97316] pl-4">
                    <p class="text-sm text-slate-400">Booking Created</p>
                    <p class="text-sm text-slate-300">{{ $booking->created_at->format('M d, Y \a\t h:i A') }}</p>
                </div>

                <div class="flex gap-3 pt-6">
                    <a href="{{ route('booking.edit', $booking) }}" class="inline-flex items-center justify-center rounded-full bg-[#f97316] px-6 py-3 text-sm font-semibold uppercase tracking-[0.15em] text-slate-950 transition hover:bg-[#fb923c]">
                        Edit Booking
                    </a>
                    <form action="{{ route('booking.destroy', $booking) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Are you sure?')" class="inline-flex items-center justify-center rounded-full border border-red-500/20 bg-red-500/10 px-6 py-3 text-sm font-semibold uppercase tracking-[0.15em] text-red-50 transition hover:bg-red-500/20">
                            Delete Booking
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

