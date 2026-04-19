<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bhub GYM and Fitness</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#020617] text-white antialiased">
    <div class="relative overflow-hidden">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,_rgba(249,115,22,0.18),_transparent_22%),radial-gradient(circle_at_bottom_right,_rgba(34,197,94,0.12),_transparent_32%)]"></div>
        <div class="relative z-10 mx-auto max-w-7xl px-6 py-8 sm:px-10 lg:px-12 lg:py-10">
            <header class="flex items-center justify-between gap-4">
                <a href="{{ route('home') }}" class="text-lg font-semibold uppercase tracking-[0.25em] text-white sm:text-xl">Bhub <span class="text-[#f97316]">GYM</span> and Fitness</a>
                <div class="flex items-center gap-3">
                    @auth
                        <a href="{{ route('dashboard') }}" class="rounded-full border border-white/20 px-5 py-2 text-sm uppercase tracking-[0.18em] text-white transition hover:bg-white/10">Dashboard</a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="rounded-full bg-[#f97316] px-5 py-2 text-sm font-semibold uppercase tracking-[0.18em] text-slate-950 transition hover:bg-[#fb923c]">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="rounded-full border border-white/20 px-5 py-2 text-sm uppercase tracking-[0.18em] text-white transition hover:bg-white/10">Login</a>
                        <a href="{{ route('register') }}" class="rounded-full bg-[#f97316] px-5 py-2 text-sm font-semibold uppercase tracking-[0.18em] text-slate-950 transition hover:bg-[#fb923c]">Sign Up</a>
                    @endauth
                </div>
            </header>

            <main class="mt-20 grid gap-16 lg:grid-cols-[1.1fr_0.9fr] lg:items-center">
                <section class="space-y-8">
                    <div class="inline-flex items-center gap-3 rounded-full border border-white/10 bg-white/5 px-4 py-2 text-xs uppercase tracking-[0.35em] text-[#f97316] shadow-sm shadow-[#f97316]/10 backdrop-blur-sm">
                        Premium fitness experience
                    </div>
                    <div class="space-y-6">
                        <h1 class="max-w-3xl text-5xl font-semibold uppercase tracking-tight text-white sm:text-6xl">Elevate Your Strength</h1>
                        <p class="max-w-2xl text-base leading-8 text-slate-300 sm:text-lg">Train smarter, move stronger, and unlock the next level of your fitness with high-energy workouts, expert coaching, and 24/7 access at Bhub GYM and Fitness.</p>
                    </div>

                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center rounded-full bg-[#f97316] px-8 py-4 text-sm font-semibold uppercase tracking-[0.18em] text-slate-950 transition hover:bg-[#fb923c]">Start Your Membership</a>
                        <a href="#services" class="inline-flex items-center justify-center rounded-full border border-white/20 px-8 py-4 text-sm uppercase tracking-[0.18em] text-white transition hover:bg-white/10">Explore Services</a>
                    </div>
                </section>

                <section class="relative overflow-hidden rounded-[2rem] border border-white/10 bg-white/5 p-8 shadow-2xl shadow-black/20 backdrop-blur-sm">
                    <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,_rgba(249,115,22,0.18),_transparent_35%)]"></div>
                    <div class="relative space-y-6">
                        <p class="text-sm uppercase tracking-[0.35em] text-[#f97316]">Built for every body</p>
                        <div class="space-y-4 text-slate-200">
                            <p class="text-xl font-semibold text-white">Feel the energy of a modern fitness center with top-tier gear, supportive coaching, and a welcoming community.</p>
                            <p class="leading-7 text-slate-300">Whether you want strength, endurance, or flexibility, Bhub GYM delivers a high-contrast fitness experience designed to keep you motivated.</p>
                        </div>
                    </div>
                </section>
            </main>

            <section id="services" class="mt-20 space-y-8 text-center">
                <p class="text-sm uppercase tracking-[0.35em] text-[#f97316]">Services</p>
                <h2 class="text-3xl font-semibold text-white sm:text-4xl">What we offer</h2>
                <div class="grid gap-6 sm:grid-cols-3">
                    <div class="rounded-[1.5rem] border border-white/10 bg-slate-950/70 p-8 text-left shadow-xl shadow-[#0f172a]/40">
                        <p class="mb-4 text-sm uppercase tracking-[0.35em] text-[#f97316]">Personal Training</p>
                        <h3 class="text-2xl font-semibold text-white">One-on-one coaching</h3>
                        <p class="mt-3 text-sm leading-6 text-slate-300">Get focused support from certified trainers who help you reach goals faster with custom workout plans.</p>
                    </div>
                    <div class="rounded-[1.5rem] border border-white/10 bg-slate-950/70 p-8 text-left shadow-xl shadow-[#0f172a]/40">
                        <p class="mb-4 text-sm uppercase tracking-[0.35em] text-[#f97316]">Group Classes</p>
                        <h3 class="text-2xl font-semibold text-white">High-energy sessions</h3>
                        <p class="mt-3 text-sm leading-6 text-slate-300">Join strength, cardio, and mobility classes that keep every workout fresh and motivating.</p>
                    </div>
                    <div class="rounded-[1.5rem] border border-white/10 bg-slate-950/70 p-8 text-left shadow-xl shadow-[#0f172a]/40">
                        <p class="mb-4 text-sm uppercase tracking-[0.35em] text-[#f97316]">24/7 Access</p>
                        <h3 class="text-2xl font-semibold text-white">Train on your schedule</h3>
                        <p class="mt-3 text-sm leading-6 text-slate-300">Enjoy flexible access to our facilities any time of day or night, making consistency easy.</p>
                    </div>
                </div>
            </section>
        </div>
    </div>
</body>
</html>
