<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'gym_id',
        'booking_time',
        'status',
    ];

    protected $casts = [
        'booking_time' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function gym()
    {
        return $this->belongsTo(Gym::class);
    }
}
