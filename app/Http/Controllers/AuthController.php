<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Gate;
use App\Models\Booking;

class AuthController extends Controller
{
    public function homepage()
    {
        return view('homepage');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember')))
        {
            $request->session()->regenerate();

            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:8'],
            'user_id' => ['required', 'string', 'max:255', 'unique:users,user_id'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'user_id' => $data['user_id'],
            'password' => Hash::make($data['password']),
        ]);

        Auth::login($user);

        return redirect()->route('dashboard')->with('status', 'Welcome to Bhub GYM and Fitness!');
    }

    public function dashboard()
    {
        // Check the Gate exactly like we do in the Blade file
        if (Gate::allows('access-admin')) {
            // You are an ADMIN: Fetch ALL bookings in the system
            $bookings = Booking::with(['user', 'gym'])->get(); 
        } else {
            // You are a USER: Fetch ONLY your personal bookings
            $bookings = Auth::user()->bookings()->with('gym')->get(); 
        }

        // Return the single dashboard view we built with the @can logic
        return view('dashboard', compact('bookings'));
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('status', 'You are logged out.');
    }
}
