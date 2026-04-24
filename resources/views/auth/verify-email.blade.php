@extends('layouts.app')

@section('content')
<div class="px-6 py-8 sm:px-10">
    <div class="mx-auto max-w-xl rounded-[2rem] border border-white/10 bg-white/5 p-8 shadow-2xl shadow-black/20 backdrop-blur-lg">
        <h2 class="text-3xl font-semibold text-white mb-6">Verify Your Email Address</h2>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-6 rounded-lg border border-emerald-500/20 bg-emerald-500/10 p-4 text-sm text-emerald-50">
                A fresh verification link has been sent to your email address.
            </div>
        @endif

        <div class="space-y-4 mb-8">
            <p class="text-slate-300">
                Thanks for signing up! Before you can continue, you need to verify your email address.
            </p>
            <p class="text-slate-300">
                We've sent a verification link to <strong class="text-white">{{ auth()->user()->email }}</strong>
            </p>
            <p class="text-slate-300">
                Didn't receive the email? We can send another one.
            </p>
        </div>

        <div class="space-y-3">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="w-full rounded-3xl bg-[#f97316] px-5 py-3 text-sm font-semibold uppercase tracking-[0.2em] text-slate-950 transition hover:bg-[#fb923c]">
                    Resend Verification Email
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full rounded-3xl border border-white/20 bg-white/5 px-5 py-3 text-sm font-semibold uppercase tracking-[0.2em] text-white transition hover:bg-white/10">
                    Logout
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

