# GYM Fitness App - Setup & Deployment Guide

This guide provides step-by-step instructions to deploy your Laravel project with all the rubric requirements met.

## Prerequisites

- PHP 8.1+ with extensions: BCMath, Ctype, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML
- Composer installed
- MySQL/MariaDB database server
- Node.js and npm (for Vite)

## Installation Steps

### 1. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install Node dependencies
npm install
```

### 2. Environment Setup

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Update .env file with your database credentials
# Set DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD
```

### 3. Database Setup

```bash
# Run all migrations (fresh database)
php artisan migrate:fresh

# Or for existing database:
php artisan migrate

# Seed the database with admin user and gyms
php artisan db:seed
```

### 4. Build Frontend Assets

```bash
# Development mode
npm run dev

# Production build
npm run build
```

### 5. Start Development Server

```bash
# Start PHP development server
php artisan serve

# In another terminal, start Node watcher for CSS/JS changes
npm run dev
```

Visit `http://localhost:8000` in your browser.

---

## Test Credentials

### Admin User
- **Email:** admin@gymfitness.com
- **Password:** admin123

### Test User (Register through the app)
Create a new user account through the registration page.

---

## Key Features Implemented

### CO1 #1: Database Design & Migrations ✅
- ✅ Fixed foreign key constraints in bookings table
- ✅ Added `role` column to users table (enum: 'user', 'admin')
- ✅ Added `email_verified_at` column for email verification
- ✅ Fixed User model/DB inconsistency (removed phoneNumber)
- ✅ Consolidated migrations (gym_id and status in create_bookings_table)

### CO1 #2: Models & Relationships ✅
- ✅ Added `$casts` array to Gym model for max_capacity integer casting
- ✅ Created query scopes:
  - `Gym::search()` - Search by name/location
  - `Gym::withAvailability()` - Get availability counts
  - `Booking::byStatus()` - Filter by status
  - `Booking::byGym()` - Filter by gym
  - `Booking::byDateRange()` - Filter by date range
  - `Booking::future()` - Get future bookings
  - `Booking::active()` - Get non-cancelled bookings
  - `Booking::byUserEmail()` - Search by user email

### CO1 #3: CRUD Operations ✅
- ✅ Added `show()` method for viewing booking details
- ✅ Fixed `destroy()` to actually delete records (not just set status)
- ✅ Dynamic slot status computation from real database data
- ✅ Gym creation via seeder (GymSeeder.php)

### CO1 #4: Input Validation ✅
- ✅ Created Form Request classes:
  - `StoreBookingRequest` - Booking creation validation
  - `UpdateBookingRequest` - Booking update validation
  - `LoginRequest` - Login validation
  - `RegisterRequest` - Registration validation
- ✅ Added validation to edit() route via UpdateBookingRequest
- ✅ Prevents duplicate bookings (same gym, slot, date)
- ✅ Custom error messages in all Form Request classes

### CO1 #5: Relational Queries & Filters ✅
- ✅ Search and filter functionality:
  - Filter by gym_id
  - Filter by status
  - Filter by date range (booking_date_from to booking_date_to)

### CO2 #1: User Authentication ✅
- ✅ Email verification implemented:
  - Users must verify email before full access
  - Resend verification email functionality
  - Email verification routes: `/email/verify`, `/email/verify/{id}/{hash}`
- ✅ "Remember me" checkbox in login form (already in frontend)

### CO2 #2: User Authorization ✅
- ✅ RBAC with role column:
  - Role values: 'user', 'admin'
  - Authorization checks via role attribute
- ✅ BookingPolicy created (`app/Policies/BookingPolicy.php`):
  - `view()` - Check if user can view booking
  - `update()` - Check if user can edit booking
  - `delete()` - Check if user can delete booking
  - `create()` - Check if user can create booking
- ✅ AppServiceProvider registers policy and gates:
  - `access-admin` gate
  - `edit-booking` gate
  - `delete-booking` gate
  - `view-booking` gate

### CO2 #3: Cookies & Session ✅
- ✅ Intentional session storage:
  - `user_last_login` - Last login timestamp
  - `user_role` - User role stored in session
  - `user_name` - User name in session
  - `booked_gyms` - Track recently booked gyms
- ✅ Cookie usage:
  - `recently_viewed_bookings` - Track recently viewed bookings (30-day expiry)
- ✅ Flash messages:
  - Success messages for booking creation/updates
  - Error messages for validation failures
  - Warning messages for business logic violations
  - Comprehensive alerts component (`resources/views/components/alerts.blade.php`)

---

## File Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── AuthController.php (updated with email verification)
│   │   ├── BookingController.php (updated with CRUD, validation, policies)
│   │   └── AdminBookingController.php
│   ├── Middleware/
│   │   └── AdminMiddleware.php
│   ├── Requests/
│   │   ├── StoreBookingRequest.php (NEW)
│   │   ├── UpdateBookingRequest.php (NEW)
│   │   ├── LoginRequest.php (NEW)
│   │   └── RegisterRequest.php (NEW)
│   └── Policies/
│       └── BookingPolicy.php (NEW)
├── Models/
│   ├── User.php (updated with role, email verification)
│   ├── Booking.php (updated with scopes)
│   └── Gym.php (updated with casts and scopes)
└── Providers/
    └── AppServiceProvider.php (updated with policy & gates)

database/
├── migrations/
│   ├── 0001_01_01_000000_create_users_table.php
│   ├── 2026_04_07_052206_create_gyms_table.php
│   ├── 2026_04_07_052214_create_bookings_table.php (consolidated)
│   ├── 2026_04_19_000001_add_gym_id_and_status_to_bookings_table.php (updated)
│   └── 2026_04_25_000001_add_role_to_users_table.php (NEW)
└── seeders/
    ├── DatabaseSeeder.php
    ├── AdminUserSeeder.php
    ├── GymSeeder.php
    └── UserSeeder.php

resources/views/
├── layouts/
│   └── app.blade.php (NEW - main layout)
├── components/
│   └── alerts.blade.php (NEW - flash messages)
├── auth/
│   ├── login.blade.php
│   ├── register.blade.php
│   └── verify-email.blade.php (NEW)
├── booking.blade.php (updated with filters)
├── booking-show.blade.php (NEW - detail view)
├── booking-edit.blade.php
├── dashboard.blade.php
└── homepage.blade.php

routes/
└── web.php (updated with email verification routes, show route)
```

---

## Database Schema Summary

### users table
- id (primary key)
- user_id (unique custom ID)
- name (string)
- email (unique string)
- **role (enum: 'user', 'admin') - NEW**
- **email_verified_at (timestamp, nullable) - NEW**
- password (string, hashed)
- remember_token (string, nullable)
- timestamps

### gyms table
- id (primary key)
- name (string)
- campus_location (string)
- max_capacity (integer) - Properly cast in model
- timestamps

### bookings table
- id (primary key)
- user_id (foreign key → users.user_id)
- gym_id (foreign key → gyms.id) - Consolidated in main migration
- booking_time (datetime)
- **status (enum: 'Confirmed', 'Pending', 'Cancelled') - Consolidated in main migration**
- timestamps

---

## Testing the Implementation

### Test Email Verification Flow
1. Register a new account
2. You'll be redirected to `/email/verify`
3. Check Laravel's email logs (in development, emails are logged to `storage/logs/`)
4. Click the verification link or use `/email/verify/{id}/{hash}`

### Test Authorization (RBAC)
1. Login as admin: admin@gymfitness.com
2. Visit `/admin/dashboard` - should work
3. Try as regular user - should be denied (403)

### Test Session Storage
1. Login and check browser DevTools → Application → Cookies/Storage
2. `recently_viewed_bookings` cookie will be set when viewing booking details
3. Session data stored: `user_last_login`, `user_role`, `user_name`

### Test Duplicate Booking Prevention
1. Book a gym at a specific time/date
2. Try to book the same gym at the same time/date again
3. Should see error: "You already have a booking for this gym at this time."

### Test Dynamic Slot Status
1. Create multiple bookings for the same gym and time slot
2. Booking index will show:
   - "Available" - Less than 75% capacity
   - "Almost Full" - 75-99% capacity
   - "Fully Booked" - 100% capacity

---

## Useful Commands

```bash
# Clear application cache
php artisan cache:clear

# Clear config cache
php artisan config:clear

# Clear route cache
php artisan route:clear

# Run tests
php artisan test

# Run specific test
php artisan test --filter=BookingTest

# Tinker - Interactive shell
php artisan tinker

# Create a new migration
php artisan make:migration migration_name

# Create a new seeder
php artisan make:seeder SeederName

# View all routes
php artisan route:list
```

---

## Troubleshooting

### Migrations failing?
```bash
# Rollback all migrations
php artisan migrate:reset

# Re-run migrations
php artisan migrate:fresh --seed
```

### Email verification not working?
- Check `config/mail.php` settings
- In development, emails are logged to `storage/logs/laravel.log`
- Verify the `from` address matches your mail configuration

### Policy authorization not working?
- Ensure `BookingPolicy` is properly registered in `AppServiceProvider`
- Check that users have the `role` column set correctly
- Use `php artisan tinker` to test manually

### Session/Cookie issues?
- Clear browser cookies and try again
- Check `config/session.php` for session configuration
- Use `php artisan cache:clear` to clear session cache

---

## Production Deployment Checklist

- [ ] Set `APP_DEBUG=false` in `.env`
- [ ] Set `APP_ENV=production` in `.env`
- [ ] Run `php artisan config:cache`
- [ ] Run `php artisan route:cache`
- [ ] Run `php artisan view:cache`
- [ ] Run `npm run build` for production assets
- [ ] Set up proper database backups
- [ ] Configure mail service for production
- [ ] Set up SSL certificate
- [ ] Configure proper logging
- [ ] Run security audit: `php artisan security:audit`
- [ ] Test all authentication flows

---

## Support & Issues

For any issues or questions, refer to:
- [Laravel Documentation](https://laravel.com/docs)
- [Tailwind CSS Documentation](https://tailwindcss.com/docs)
- Application logs: `storage/logs/laravel.log`
