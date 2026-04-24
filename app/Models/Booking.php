<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'gym_id',
        'booking_time',
        'status',
    ];

    protected $casts = [
        'booking_time' => 'datetime',
        'status' => 'string',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function gym()
    {
        return $this->belongsTo(Gym::class);
    }

    /**
     * Scope to filter bookings by status
     */
    public function scopeByStatus($query, $status)
    {
        if (!$status) {
            return $query;
        }
        return $query->where('status', $status);
    }

    /**
     * Scope to filter bookings by gym
     */
    public function scopeByGym($query, $gymId)
    {
        if (!$gymId) {
            return $query;
        }
        return $query->where('gym_id', $gymId);
    }

    /**
     * Scope to filter bookings by date range
     */
    public function scopeByDateRange($query, $startDate, $endDate)
    {
        if (!$startDate || !$endDate) {
            return $query;
        }
        return $query->whereBetween('booking_time', [$startDate, $endDate]);
    }

    /**
     * Scope to get future bookings only
     */
    public function scopeFuture($query)
    {
        return $query->where('booking_time', '>=', now());
    }

    /**
     * Scope to get active bookings (not cancelled)
     */
    public function scopeActive($query)
    {
        return $query->where('status', '!=', 'Cancelled');
    }

    /**
     * Scope to search by user email
     */
    public function scopeByUserEmail($query, $email)
    {
        if (!$email) {
            return $query;
        }
        return $query->whereHas('user', function ($q) use ($email) {
            $q->where('email', 'like', "%{$email}%");
        });
    }
}
