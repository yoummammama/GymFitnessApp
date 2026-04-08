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

    public function bookings()
    {
    return $this->hasMany(Booking::class);
    }
}
