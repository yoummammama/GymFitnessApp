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

            // Store intentional session data
            $user = Auth::user();
            $request->session()->put([
                'user_last_login' => now(),
                'user_role' => $user->role,
                'user_name' => $user->name,
            ]);

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
        ]);

        // Send verification email
        $user->sendEmailVerificationNotification();

        Auth::login($user);

        return redirect()->route('verification.notice')->with('status', 'Account created! Please verify your email to continue.');
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

    /**
     * Show email verification notice
     */
    public function verifyEmail()
    {
        return view('auth.verify-email');
    }

    /**
     * Handle email verification
     */
    public function verifyHandler(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('dashboard')->with('status', 'Email already verified.');
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new \Illuminate\Auth\Events\Verified($request->user()));
        }

        return redirect()->route('dashboard')->with('status', 'Email verified successfully!');
    }

    /**
     * Resend verification email
     */
    public function resendVerificationEmail(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('dashboard')->with('status', 'Email already verified.');
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('status', 'Verification email has been resent.');
    }
}
