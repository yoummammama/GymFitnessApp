<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign Up - Bhub GYM and Fitness</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#020617] text-white">
    <div class="min-h-screen bg-[radial-gradient(circle_at_top,_rgba(245,75,66,0.18),_transparent_25%),radial-gradient(circle_at_bottom_left,_rgba(59,130,246,0.12),_transparent_30%)] px-6 py-8 sm:px-10">
        <div class="mx-auto max-w-xl rounded-[2rem] border border-white/10 bg-white/5 p-8 shadow-2xl shadow-black/20 backdrop-blur-lg">
            <header class="flex items-center justify-between mb-10">
                <a href="{{ route('home') }}" class="text-xl font-semibold tracking-tight text-white"><span class="text-[#f97316]">GYM</span> and Fitness</a>
                <a href="{{ route('login') }}" class="rounded-full border border-white/20 bg-white/5 px-5 py-2 text-sm uppercase tracking-[0.2em] text-white hover:bg-white/10">Login</a>
            </header>

            <div class="mb-8 space-y-3">
                <p class="text-sm uppercase tracking-[0.35em] text-[#f97316]">Start your journey</p>
                <h1 class="text-3xl font-semibold text-white sm:text-4xl">Become a member today.</h1>
                <p class="text-slate-300">Sign up now to access personal coaching, group classes, and 24/7 gym access.</p>
            </div>

            @if ($errors->any())
                <div class="mb-6 rounded-3xl border border-red-500/20 bg-red-500/10 p-4 text-sm text-red-100">
                    <ul class="space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf

                <label class="block text-sm font-medium text-slate-200">
                    Full name
                    <input type="text" name="name" value="{{ old('name') }}" required class="mt-2 w-full rounded-3xl border border-white/10 bg-slate-950/70 px-4 py-3 text-white outline-none transition focus:border-[#f97316] focus:ring-2 focus:ring-[#f97316]/30" />
                </label>

                <label class="block text-sm font-medium text-slate-200">
                    Email address
                    <input type="email" name="email" value="{{ old('email') }}" required class="mt-2 w-full rounded-3xl border border-white/10 bg-slate-950/70 px-4 py-3 text-white outline-none transition focus:border-[#f97316] focus:ring-2 focus:ring-[#f97316]/30" />
                </label>

                <label class="block text-sm font-medium text-slate-200">
                    User ID
                    <input type="text" name="user_id" value="{{ old('user_id') }}" required class="mt-2 w-full rounded-3xl border border-white/10 bg-slate-950/70 px-4 py-3 text-white outline-none transition focus:border-[#f97316] focus:ring-2 focus:ring-[#f97316]/30" />
                </label>

                <div class="grid gap-6 sm:grid-cols-2">
                    <label class="block text-sm font-medium text-slate-200">
                        Password
                        <input type="password" name="password" required class="mt-2 w-full rounded-3xl border border-white/10 bg-slate-950/70 px-4 py-3 text-white outline-none transition focus:border-[#f97316] focus:ring-2 focus:ring-[#f97316]/30" />
                    </label>
                    <label class="block text-sm font-medium text-slate-200">
                        Confirm password
                        <input type="password" name="password_confirmation" required class="mt-2 w-full rounded-3xl border border-white/10 bg-slate-950/70 px-4 py-3 text-white outline-none transition focus:border-[#f97316] focus:ring-2 focus:ring-[#f97316]/30" />
                    </label>
                </div>

                <button type="submit" class="w-full rounded-3xl bg-[#f97316] px-5 py-3 text-sm font-semibold uppercase tracking-[0.2em] text-slate-950 transition hover:bg-[#fb923c]">Create Account</button>
            </form>
        </div>
    </div>
</body>
</html>
