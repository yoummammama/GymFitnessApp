<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $primaryKey = 'user_id';

    // IMPORTANT: If 'user_id' is NOT an auto-incrementing integer (e.g., it is '122' but managed manually), 
    // you must add these two lines so Laravel doesn't try to "guess" the ID type.
    public $incrementing = false; 
    protected $keyType = 'string';
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'password',
        'phoneNumber',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'user_id','user_id');
    }

    // Inside User.php

    public function admin()
    {
        // A user has one admin profile (if they are an admin)
        return $this->hasOne(Admin::class, 'user_id', 'user_id');   
    }

    /**
     * Helper to check if the user has admin privileges
     */
    public function isAdmin(): bool
    {
        return $this->admin()->exists();
    }
}
