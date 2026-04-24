<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Gym extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'campus_location',
        'max_capacity',
    ];

    protected $casts = [
        'max_capacity' => 'integer',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Scope to search gyms by name or location
     */
    public function scopeSearch($query, $term)
    {
        if (!$term) {
            return $query;
        }
        return $query->where('name', 'like', "%{$term}%")
                    ->orWhere('campus_location', 'like', "%{$term}%");
    }

    /**
     * Scope to get gyms with available capacity
     */
    public function scopeWithAvailability($query)
    {
        return $query->withCount(['bookings' => function ($q) {
            $q->where('status', '!=', 'Cancelled')
              ->where('booking_time', '>=', now());
        }]);
    }
}
