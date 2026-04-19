<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - Bhub GYM and Fitness</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#020617] text-white">
    <div class="min-h-screen bg-[radial-gradient(circle_at_top,_rgba(245,75,66,0.18),_transparent_20%),radial-gradient(circle_at_bottom_right,_rgba(14,165,233,0.12),_transparent_35%)] px-6 py-8 sm:px-10">
        <div class="mx-auto max-w-4xl rounded-[2rem] border border-white/10 bg-white/5 p-8 shadow-2xl shadow-black/20 backdrop-blur-lg">
            <header class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between mb-10">
                <div>
                    <p class="text-sm uppercase tracking-[0.35em] text-[#f97316]">Bhub GYM and Fitness</p>
                    <h1 class="mt-3 text-3xl font-semibold text-white sm:text-4xl">Hello, {{ Auth::user()->name }}.</h1>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="rounded-full bg-[#f97316] px-6 py-3 text-sm font-semibold uppercase tracking-[0.2em] text-slate-950 transition hover:bg-[#fb923c]">Sign Out</button>
                </form>
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
        </div>
    </div>
</body>
</html>
