<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
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

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();
        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember))
        {
            $request->session()->regenerate();

            $user = Auth::user();
            $previousLogin = $user->last_login_at;

            // Store intentional session data using the previous login timestamp
            $request->session()->put([
                'user_last_login' => $previousLogin,
                'user_role' => $user->isAdmin() ? 'Admin' : ($user->role ?? 'User'),
                'user_name' => $user->name,
            ]);

            $user->update(['last_login_at' => now()]);

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

    public function register(RegisterRequest $request)
    {
        $data = $request->validated();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'user_id' => $data['user_id'],
            'password' => Hash::make($data['password']),
            'role' => 'user', // Default role
            'last_login_at' => now(),
        ]);

        Auth::login($user);

        return redirect()->route('dashboard')->with('status', 'Account created successfully.');
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
