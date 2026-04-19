<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GYM and Fitness</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .slider-item {
            position: absolute;
            inset: 0;
            background-size: cover;
            background-position: center;
            opacity: 0.5;
            animation: fade 30s ease-in-out infinite;
            animation-fill-mode: both;
        }
        .slider-item:nth-child(1) { animation-delay: 0s; }
        .slider-item:nth-child(2) { animation-delay: 6s; }
        .slider-item:nth-child(3) { animation-delay: 12s; }
        .slider-item:nth-child(4) { animation-delay: 18s; }
        .slider-item:nth-child(5) { animation-delay: 24s; }

@keyframes fade {
        0% { opacity: 0; }
        2% { opacity: 0.7; }  /* Fade in quickly (at 0.6s) */
        18% { opacity: 0.7; } /* Stay visible until 5.4s */
        20% { opacity: 0; }  /* Fade out by 6s */
        100% { opacity: 0; } /* Stay hidden for the rest of the 30s */
    }
    </style>
</head>
<body class="min-h-screen bg-[#020617] text-white antialiased">

    <div class="fixed inset-0 z-0 overflow-hidden">
        <div class="slider-item bg-[url('https://images.unsplash.com/photo-1517836357463-d25dfeac3438?auto=format&fit=crop&w=1920&q=80')] opacity-20"></div>
        <div class="slider-item bg-[url('https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?auto=format&fit=crop&w=1920&q=80')] opacity-20"></div>
        <div class="slider-item bg-[url('https://th.bing.com/th/id/OIP.8outD7UeIAEcsH1hgvABQgHaFj?o=7rm=3&rs=1&pid=ImgDetMain&o=7&rm=3')] opacity-20"></div>
        <div class="slider-item bg-[url('https://www.optionstheedge.com/sites/default/files/assets/2020/bb_gym.jpg')] opacity-20"></div>
        <div class="slider-item bg-[url('https://images.pexels.com/photos/414029/pexels-photo-414029.jpeg?auto=compress&cs=tinysrgb&w=1600')] opacity-20"></div>
        <div class="absolute inset-0 bg-black/70"></div>
    </div>

    <div class="relative z-20 min-h-screen flex items-center justify-center px-6 py-8 sm:px-10">
        <div class="w-full max-w-2xl">
            <header class="flex items-center justify-between gap-4 mb-10">
                <a href="{{ route('home') }}" class="text-lg font-semibold uppercase tracking-[0.25em] text-white sm:text-xl"><span class="text-[#f97316]">GYM</span> and Fitness</a>
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

            <section class="relative overflow-hidden rounded-[2.5rem] border border-white/10 bg-white/5 p-10 shadow-2xl shadow-black/30 backdrop-blur-xl">
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_center,_rgba(249,115,22,0.15),_transparent_35%)]"></div>
                <div class="relative space-y-8">
                    <span class="inline-flex items-center gap-3 rounded-full border border-white/10 bg-white/5 px-4 py-2 text-xs uppercase tracking-[0.35em] text-[#f97316] shadow-sm shadow-[#f97316]/10 backdrop-blur-sm">Premium fitness experience</span>
                    <div class="space-y-6">
                        <h1 class="text-5xl font-semibold uppercase tracking-tight text-white sm:text-6xl">Elevate Your Strength</h1>
                        <p class="max-w-2xl text-base leading-8 text-slate-300 sm:text-lg">Train smarter, move stronger, and unlock the next level of your fitness with high-energy workouts, expert coaching, and 24/7 access at GYM and Fitness.</p>
                    </div>

                    <div class="grid gap-6 rounded-[1.75rem] border border-white/10 bg-white/5 p-6 text-left text-slate-200 shadow-lg shadow-black/10">
                        <p class="text-sm uppercase tracking-[0.35em] text-[#f97316]">Quick booking preview</p>
                        <div class="grid gap-3 sm:grid-cols-3">
                            <div class="rounded-2xl bg-slate-950/70 p-4">
                                <p class="text-xs uppercase tracking-[0.35em] text-slate-400">Branch</p>
                                <p class="mt-2 text-sm font-semibold text-white">City Center</p>
                            </div>
                            <div class="rounded-2xl bg-slate-950/70 p-4">
                                <p class="text-xs uppercase tracking-[0.35em] text-slate-400">Date</p>
                                <p class="mt-2 text-sm font-semibold text-white">Tomorrow</p>
                            </div>
                            <div class="rounded-2xl bg-slate-950/70 p-4">
                                <p class="text-xs uppercase tracking-[0.35em] text-slate-400">Time</p>
                                <p class="mt-2 text-sm font-semibold text-white">6:00 PM</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center rounded-full bg-[#f97316] px-8 py-4 text-sm font-semibold uppercase tracking-[0.18em] text-slate-950 transition hover:bg-[#fb923c]">Start Your Membership</a>
                        <a href="#services" class="inline-flex items-center justify-center rounded-full border border-white/20 px-8 py-4 text-sm uppercase tracking-[0.18em] text-white transition hover:bg-white/10">Explore Services</a>
                    </div>
                </div>
            </section>
        </div>
    </div>

</body>
</html>
