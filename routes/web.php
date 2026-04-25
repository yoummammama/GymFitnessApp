<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AdminBookingController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'homepage'])->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::get('/booking', [BookingController::class, 'index'])->name('booking.index');
    Route::get('/booking/{booking}', [BookingController::class, 'show'])->name('booking.show');
    Route::get('/booking/{booking}/edit', [BookingController::class, 'edit'])->name('booking.edit');
    Route::put('/booking/{booking}', [BookingController::class, 'update'])->name('booking.update');
    Route::delete('/booking/{booking}', [BookingController::class, 'destroy'])->name('booking.destroy');
    Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
});

// Admin routes - protected by auth and can:access-admin-panel middleware
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminBookingController::class, 'dashboard'])->name('dashboard');
    Route::patch('/booking/{booking}', [AdminBookingController::class, 'update'])->name('booking.update');
    Route::delete('/booking/{booking}', [AdminBookingController::class, 'destroy'])->name('booking.destroy');
    Route::resource('gyms', \App\Http\Controllers\AdminGymController::class)->except(['show']);
});


