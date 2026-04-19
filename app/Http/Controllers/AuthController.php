<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
            'student_id' => ['required', 'string', 'max:255', 'unique:users,student_id'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'student_id' => $data['student_id'],
            'password' => Hash::make($data['password']),
        ]);

        Auth::login($user);

        return redirect()->route('dashboard')->with('status', 'Welcome to Bhub GYM and Fitness!');
    }

    public function dashboard()
    {
        $bookings = Auth::user()->bookings()
            ->with('gym')
            ->where('status', '!=', 'Cancelled')
            ->where('booking_time', '>=', now())
            ->orderBy('booking_time')
            ->get();

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
