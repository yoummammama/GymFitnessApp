<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add New Gym - GYM and Fitness</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#020617] text-white antialiased">
    <div class="min-h-screen bg-[radial-gradient(circle_at_top,_rgba(245,75,66,0.18),_transparent_20%),radial-gradient(circle_at_bottom_right,_rgba(14,165,233,0.12),_transparent_35%)] px-6 py-8 sm:px-10">
        <div class="mx-auto max-w-2xl rounded-[2rem] border border-white/10 bg-white/5 p-8 shadow-2xl shadow-black/20 backdrop-blur-lg">
            <header class="mb-10">
                <p class="text-sm uppercase tracking-[0.35em] text-[#f97316]">GYM and Fitness</p>
                <h1 class="mt-3 text-3xl font-semibold text-white sm:text-4xl">Add New Gym</h1>
            </header>

            <div class="rounded-[1.75rem] border border-white/10 bg-slate-950/70 p-8 shadow-xl shadow-black/20">
                <form method="POST" action="{{ route('admin.gyms.store') }}" class="space-y-6">
                    @csrf

                    {{-- Name Field --}}
                    <div>
                        <label for="name" class="block text-sm font-medium text-slate-200">
                            Gym Name
                        </label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            required
                            class="mt-2 w-full rounded-3xl border border-white/10 bg-slate-950/70 px-4 py-3 text-white outline-none transition focus:border-[#f97316] focus:ring-2 focus:ring-[#f97316]/30"
                            placeholder="e.g., Downtown Fitness Center"
                        />
                        @error('name')
                            <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Campus Location Field --}}
                    <div>
                        <label for="campus_location" class="block text-sm font-medium text-slate-200">
                            Campus Location
                        </label>
                        <input
                            type="text"
                            id="campus_location"
                            name="campus_location"
                            value="{{ old('campus_location') }}"
                            required
                            class="mt-2 w-full rounded-3xl border border-white/10 bg-slate-950/70 px-4 py-3 text-white outline-none transition focus:border-[#f97316] focus:ring-2 focus:ring-[#f97316]/30"
                            placeholder="e.g., Main Campus, Building A"
                        />
                        @error('campus_location')
                            <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Max Capacity Field --}}
                    <div>
                        <label for="max_capacity" class="block text-sm font-medium text-slate-200">
                            Maximum Capacity
                        </label>
                        <input
                            type="number"
                            id="max_capacity"
                            name="max_capacity"
                            value="{{ old('max_capacity') }}"
                            required
                            min="1"
                            max="500"
                            class="mt-2 w-full rounded-3xl border border-white/10 bg-slate-950/70 px-4 py-3 text-white outline-none transition focus:border-[#f97316] focus:ring-2 focus:ring-[#f97316]/30"
                            placeholder="e.g., 100"
                        />
                        @error('max_capacity')
                            <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Buttons --}}
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center pt-4">
                        <button type="submit" class="w-full rounded-3xl bg-[#f97316] px-6 py-4 text-sm font-semibold uppercase tracking-[0.18em] text-slate-950 transition hover:bg-[#fb923c]">Create Gym</button>
                        <a href="{{ route('admin.gyms.index') }}" class="inline-flex items-center justify-center rounded-full border border-white/20 bg-white/5 px-6 py-3 text-sm uppercase tracking-[0.15em] text-white transition hover:bg-white/10">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
