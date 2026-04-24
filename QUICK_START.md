# Quick Start Commands

## Initial Setup

```bash
# Navigate to project
cd GymFitnessApp

# Install PHP dependencies
composer install

# Install Node dependencies
npm install

# Copy environment file and generate key
cp .env.example .env
php artisan key:generate

# Configure database in .env
# Edit these lines:
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=gym_fitness_app
# DB_USERNAME=root
# DB_PASSWORD=your_password
```

## Database Setup

```bash
# Fresh database with all migrations and seeds
php artisan migrate:fresh --seed

# OR if database exists
php artisan migrate
php artisan db:seed

# Rollback all migrations
php artisan migrate:reset

# Rollback last batch
php artisan migrate:rollback
```

## Development Servers

```bash
# Terminal 1: Start PHP development server
php artisan serve

# Terminal 2: Build frontend assets (watch mode)
npm run dev

# Build for production
npm run build
```

## Testing & Debugging

```bash
# Run Laravel tests
php artisan test

# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear

# Interactive shell (Tinker)
php artisan tinker

# View all routes
php artisan route:list

# View database
php artisan db
```

## Common Artisan Commands

```bash
# Create new controller
php artisan make:controller ControllerName

# Create new migration
php artisan make:migration migration_name

# Create new model
php artisan make:model ModelName

# Create new seeder
php artisan make:seeder SeederName

# Create Form Request
php artisan make:request RequestName

# Create Policy
php artisan make:policy PolicyName

# Generate app key
php artisan key:generate
```

## Production Deployment

```bash
# Optimize configuration
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache views
php artisan view:cache

# Build assets
npm run build

# Install production dependencies only
npm install --production
```

## Troubleshooting

```bash
# Reset everything for a clean start
php artisan migrate:fresh --seed
php artisan cache:clear
npm run build

# Check if PHP artisan works
php artisan --version

# Generate missing autoload
composer dump-autoload

# Check Laravel configuration
php artisan config:show

# List all database tables
php artisan db:show
```

## Key Credentials

| Account | Email | Password |
|---------|-------|----------|
| Admin | admin@gymfitness.com | admin123 |

## Testing URLs

```
Homepage: http://localhost:8000
Login: http://localhost:8000/login
Register: http://localhost:8000/register
Dashboard: http://localhost:8000/dashboard
Bookings: http://localhost:8000/booking
Admin Dashboard: http://localhost:8000/admin/dashboard (admin only)
Email Verify: http://localhost:8000/email/verify
```

## Important File Locations

```
Configuration: .env
Database Migrations: database/migrations/
Models: app/Models/
Controllers: app/Http/Controllers/
Validation Requests: app/Http/Requests/
Authorization Policies: app/Policies/
Views: resources/views/
Routes: routes/web.php
Seeders: database/seeders/
```

---

**For full documentation, see IMPLEMENTATION.md and SETUP.md**
