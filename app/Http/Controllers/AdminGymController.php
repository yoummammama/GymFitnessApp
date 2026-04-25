<?php

namespace App\Http\Controllers;

use App\Models\Gym;
use App\Http\Requests\GymRequest;

class AdminGymController extends Controller
{
    /**
     * Display all gyms
     */
    public function index()
    {
        $gyms = Gym::withCount('bookings')->get();

        return view('admin.gyms.index', compact('gyms'));
    }

    /**
     * Show the create form
     */
    public function create()
    {
        return view('admin.gyms.create');
    }

    /**
     * Store a new gym
     */
    public function store(GymRequest $request)
    {
        $validated = $request->validated();

        Gym::create($validated);

        return redirect()->route('admin.gyms.index')->with('status', 'Gym created successfully.');
    }

    /**
     * Show the edit form
     */
    public function edit(Gym $gym)
    {
        return view('admin.gyms.edit', compact('gym'));
    }

    /**
     * Update an existing gym
     */
    public function update(GymRequest $request, Gym $gym)
    {
        $validated = $request->validated();

        $gym->update($validated);

        return redirect()->route('admin.gyms.index')->with('status', 'Gym updated successfully.');
    }

    /**
     * Delete a gym
     */
    public function destroy(Gym $gym)
    {
        $gym->delete();

        return redirect()->route('admin.gyms.index')->with('status', 'Gym deleted successfully.');
    }
}
