<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manage Gyms - GYM and Fitness</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#020617] text-white antialiased">
    <div class="min-h-screen bg-[radial-gradient(circle_at_top,_rgba(245,75,66,0.18),_transparent_20%),radial-gradient(circle_at_bottom_right,_rgba(14,165,233,0.12),_transparent_35%)] px-6 py-8 sm:px-10">
        <div class="mx-auto max-w-6xl rounded-[2rem] border border-white/10 bg-white/5 p-8 shadow-2xl shadow-black/20 backdrop-blur-lg">
            <header class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between mb-10">
                <div>
                    <p class="text-sm uppercase tracking-[0.35em] text-[#f97316]">GYM and Fitness</p>
                    <h1 class="mt-3 text-3xl font-semibold text-white sm:text-4xl">Manage Gyms</h1>
                </div>
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center justify-center rounded-full border border-white/20 bg-white/5 px-6 py-3 text-sm uppercase tracking-[0.15em] text-white transition hover:bg-white/10">Back to Dashboard</a>
                    <a href="{{ route('admin.gyms.create') }}" class="inline-flex items-center justify-center rounded-full bg-[#f97316] px-6 py-3 text-sm font-semibold uppercase tracking-[0.15em] text-slate-950 transition hover:bg-[#fb923c]">Add New Gym</a>
                </div>
            </header>

            @if (session('status'))
                <div class="mb-8 rounded-3xl border border-emerald-500/20 bg-emerald-500/10 p-4 text-sm text-emerald-50">{{ session('status') }}</div>
            @endif

            <div class="rounded-[1.75rem] border border-white/10 bg-slate-950/70 p-8 shadow-xl shadow-black/20">
                @if ($gyms->isEmpty())
                    <div class="rounded-[1.5rem] border border-white/10 bg-[#0f172a] p-6 text-slate-300">
                        No gyms found. <a href="{{ route('admin.gyms.create') }}" class="text-[#f97316] font-semibold hover:underline">Create one now</a>.
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-left text-sm text-slate-300">
                            <thead class="border-b border-white/10 text-xs uppercase tracking-[0.25em] text-slate-500">
                                <tr>
                                    <th class="px-4 py-3">Name</th>
                                    <th class="px-4 py-3">Location</th>
                                    <th class="px-4 py-3">Capacity</th>
                                    <th class="px-4 py-3">Total Bookings</th>
                                    <th class="px-4 py-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5">
                                @foreach ($gyms as $gym)
                                    <tr>
                                        <td class="px-4 py-4 text-white font-semibold">{{ $gym->name }}</td>
                                        <td class="px-4 py-4">{{ $gym->campus_location }}</td>
                                        <td class="px-4 py-4">{{ $gym->max_capacity }}</td>
                                        <td class="px-4 py-4">{{ $gym->bookings_count }}</td>
                                        <td class="px-4 py-4 space-x-2">
                                            <a href="{{ route('admin.gyms.edit', $gym) }}" class="inline-flex rounded-full border border-white/10 bg-white/5 px-4 py-2 text-xs font-semibold uppercase tracking-[0.15em] text-white transition hover:bg-white/10">Edit</a>
                                            <form method="POST" action="{{ route('admin.gyms.destroy', $gym) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this gym?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex rounded-full border border-red-500/30 bg-red-500/10 px-4 py-2 text-xs font-semibold uppercase tracking-[0.15em] text-red-300 transition hover:bg-red-500/20">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
