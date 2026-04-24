<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use App\Models\User;
use App\Models\Booking;
use App\Policies\BookingPolicy;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Booking::class => BookingPolicy::class,
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);

        // Define the access-admin Gate - now checks role column
        Gate::define('access-admin', function (User $user) {
            return $user->role === 'admin' || $user->admin()->exists();
        });

        // Define edit-booking Gate using the policy
        Gate::define('edit-booking', function (User $user, Booking $booking) {
            return (new BookingPolicy())->update($user, $booking);
        });

        // Define delete-booking Gate using the policy
        Gate::define('delete-booking', function (User $user, Booking $booking) {
            return (new BookingPolicy())->delete($user, $booking);
        });

        // Define view-booking Gate using the policy
        Gate::define('view-booking', function (User $user, Booking $booking) {
            return (new BookingPolicy())->view($user, $booking);
        });
    }
}

