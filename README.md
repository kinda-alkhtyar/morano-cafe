# MORANO+ Laravel website

This repository contains the MORANO+ cafe website in Laravel 12 with a Filament 4 admin panel. The homepage design and its database-backed content foundation are complete locally. See [PROJECT_STATUS.md](PROJECT_STATUS.md) for the handoff and pending work; [PHASE1.md](PHASE1.md) and [PHASE2.md](PHASE2.md) record earlier implementation details.

## Architecture

- `routes/web.php` and `app/Http/Controllers/PageController.php` serve the homepage, menu, offers, and informational routes.
- `resources/views/` contains Blade layouts, pages, and shared components. `resources/css/app.css` and `resources/js/app.js` provide the responsive design and motion; Vite builds the assets.
- `app/Models/` and `database/migrations/` define users, categories, products, offers, allergens, and the single homepage content record. Featured products, active offers, category slots, images, business details, and selected homepage copy are database driven.
- `app/Filament/Resources/` provides catalog and homepage content editing. Access requires a verified admin user. Public images are in `public/images/`; uploaded images use Laravel's public disk.
- `tests/Feature/` covers public content and admin access.

## Resume development locally

Use PHP 8.3, Composer, MySQL, Node.js, and npm. From this repository directory:

```powershell
composer install
Copy-Item .env.example .env
php artisan key:generate
# Set DB_USERNAME and DB_PASSWORD in the local .env, and create the configured MySQL database.
php artisan migrate
php artisan storage:link
npm.cmd install
npm.cmd run build
php vendor/bin/phpunit
php artisan serve --host=127.0.0.1 --port=8000
```

Open `http://127.0.0.1:8000/`. The admin login is at `/admin/login`. To create the first verified admin, run `php artisan morano:create-admin` interactively. Never commit `.env`, passwords, keys, `vendor/`, or `node_modules/`.

## Current verification

On 15 November 2026, `php vendor/bin/phpunit` passed: **10 tests, 67 assertions**. Browser visual verification remains outstanding, including responsive layouts, navigation, animation, reduced motion, and console inspection. The approved design should be reviewed visually before release.
