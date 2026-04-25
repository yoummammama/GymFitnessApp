@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[radial-gradient(circle_at_top,_rgba(245,75,66,0.15),_transparent_25%),radial-gradient(circle_at_bottom_right,_rgba(14,165,233,0.1),_transparent_30%)] px-6 py-8 sm:px-10">
    <div class="mx-auto max-w-3xl">
        <div class="rounded-[2rem] border border-white/10 bg-slate-950/80 p-8 shadow-2xl shadow-black/30 backdrop-blur-xl">
            {{-- Header --}}
            <div class="flex items-center justify-between mb-10">
                <div>
                    <p class="text-sm uppercase tracking-[0.35em] text-[#f97316]">GYM and Fitness</p>
                    <h2 class="mt-2 text-3xl font-semibold text-white">Booking Details</h2>
                </div>
                <a href="{{ route('booking.index') }}" class="group flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-4 py-2 text-sm text-slate-300 transition hover:bg-white/10 hover:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform group-hover:-translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Back
                </a>
            </div>

            {{-- Booking ID Badge --}}
            <div class="mb-8 flex items-center gap-4 rounded-2xl border border-white/10 bg-white/5 p-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-full bg-[#f97316]/20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#f97316]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Booking ID</p>
                    <p class="text-xl font-bold text-white">#{{ $booking->id }}</p>
                </div>
                <div class="ml-auto">
                    <span class="inline-flex items-center rounded-full px-4 py-1.5 text-sm font-semibold uppercase tracking-[0.1em] @if($booking->status === 'Confirmed') border border-emerald-500/30 bg-emerald-500/10 text-emerald-400 @elseif($booking->status === 'Pending') border border-yellow-500/30 bg-yellow-500/10 text-yellow-400 @else border border-red-500/30 bg-red-500/10 text-red-400 @endif">
                        {{ $booking->status }}
                    </span>
                </div>
            </div>

            {{-- Details Grid --}}
            <div class="grid gap-4">
                {{-- Gym Info --}}
                <div class="group rounded-2xl border border-white/10 bg-white/5 p-6 transition hover:border-[#f97316]/30 hover:bg-white/[0.07]">
                    <div class="flex items-start gap-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-[#f97316]/10">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#f97316]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Gym Branch</p>
                            <p class="mt-1 text-lg font-semibold text-white">{{ $booking->gym->name }}</p>
                            <p class="mt-1 text-sm text-slate-400">{{ $booking->gym->campus_location }}</p>
                        </div>
                    </div>
                </div>

                {{-- Member Info --}}
                <div class="group rounded-2xl border border-white/10 bg-white/5 p-6 transition hover:border-[#f97316]/30 hover:bg-white/[0.07]">
                    <div class="flex items-start gap-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-sky-500/10">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-sky-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Member</p>
                            <p class="mt-1 text-lg font-semibold text-white">{{ $booking->user->name }}</p>
                            <p class="mt-1 text-sm text-slate-400">{{ $booking->user->email }}</p>
                        </div>
                    </div>
                </div>

                {{-- Date & Time --}}
                <div class="group rounded-2xl border border-white/10 bg-white/5 p-6 transition hover:border-[#f97316]/30 hover:bg-white/[0.07]">
                    <div class="flex items-start gap-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-violet-500/10">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-violet-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Date & Time</p>
                            <p class="mt-1 text-lg font-semibold text-white">{{ $booking->booking_time->format('l, F d, Y') }}</p>
                            <p class="mt-1 text-sm text-slate-400">{{ $booking->booking_time->format('h:i A') }}</p>
                        </div>
                    </div>
                </div>

                {{-- Created At --}}
                <div class="group rounded-2xl border border-white/10 bg-white/5 p-6 transition hover:border-[#f97316]/30 hover:bg-white/[0.07]">
                    <div class="flex items-start gap-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-500/10">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Created</p>
                            <p class="mt-1 text-sm text-slate-300">{{ $booking->created_at->format('l, F d, Y \a\t h:i A') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="mt-10 flex flex-col gap-3 sm:flex-row">
                <a href="{{ route('booking.edit', $booking) }}" class="flex-1 flex items-center justify-center gap-2 rounded-full bg-[#f97316] px-6 py-4 text-sm font-semibold uppercase tracking-[0.15em] text-slate-950 transition hover:bg-[#fb923c] hover:shadow-lg hover:shadow-[#f97316]/20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit Booking
                </a>
                <form action="{{ route('booking.destroy', $booking) }}" method="POST" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Are you sure you want to delete this booking?')" class="w-full flex items-center justify-center gap-2 rounded-full border border-red-500/30 bg-red-500/10 px-6 py-4 text-sm font-semibold uppercase tracking-[0.15em] text-red-400 transition hover:bg-red-500/20 hover:border-red-500/50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Delete Booking
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

