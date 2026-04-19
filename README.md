# Bhub GYM and Fitness

A modern, responsive fitness center website built with Laravel and Tailwind CSS. Features a sleek dark theme with high-energy fitness aesthetic, user authentication, and booking system.

## Getting Started

### Prerequisites

- PHP 8.1 or higher
- Composer
- Node.js and npm
- MySQL or another database supported by Laravel

### Installation

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd GymFitnessSystem
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node.js dependencies**
   ```bash
   npm install
   ```

4. **Environment Setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Database Setup**
   ```bash
   # Configure your database in .env file
   php artisan migrate
   php artisan db:seed  # Optional: seed with sample data
   ```

### Running the Application

Before starting the project, you need to run these two commands in separate terminals:

1. **Start the Vite development server** (for compiling assets):
   ```bash
   npm run dev
   ```

2. **Start the Laravel development server**:
   ```bash
   php artisan serve
   ```

The application will be available at `http://127.0.0.1:8000`

### Available Routes

- `/` - Homepage with gym services and registration CTA
- `/login` - User login page
- `/register` - User registration page
- `/dashboard` - User dashboard (authenticated users only)

## Features

- **Responsive Design**: Modern dark theme with Tailwind CSS
- **User Authentication**: Login and registration system
- **Gym Services**: Showcase of Personal Training, Group Classes, and 24/7 Access
- **Booking System**: Integrated with gym models and user bookings
- **High-Contrast UI**: Fitness-focused design with orange accents

## Tech Stack

- **Backend**: Laravel 11
- **Frontend**: Tailwind CSS 4.0, Alpine.js
- **Database**: MySQL with Eloquent ORM
- **Build Tool**: Vite
- **Authentication**: Laravel Sanctum/Session

## Project Structure

```
app/
├── Http/Controllers/AuthController.php
├── Models/
│   ├── User.php
│   ├── Gym.php
│   └── Booking.php
database/
├── migrations/
└── seeders/
resources/
├── css/app.css
├── js/app.js
├── views/
│   ├── homepage.blade.php
│   ├── auth/
│   │   ├── login.blade.php
│   │   └── register.blade.php
│   └── dashboard.blade.php
routes/
└── web.php
```

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Run tests if available
5. Submit a pull request

## License

This project is licensed under the MIT License.
"# This-Is-An-ASS" 
