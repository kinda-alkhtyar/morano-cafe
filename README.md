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

Run `php vendor/bin/phpunit` and `npm run build` before release. Browser visual verification remains necessary after deployment.

## Railway deployment

The compiled Vite manifest and hashed CSS/JS files under `public/build/` are committed so a Railway deployment serves the same tested assets even when its PHP build does not run Node. Run `npm run build` locally and commit the updated manifest and assets whenever CSS or JavaScript changes. Laravel trusts Railway's forwarded HTTPS scheme in production; set `APP_URL` to the public HTTPS URL and keep `APP_ENV=production` and `APP_DEBUG=false` in Railway settings.

After a deployment, run `php artisan migrate --force` in the Railway service and verify with `php artisan migrate:status`. For a **first import into an empty product catalog only**, run `php artisan db:seed --class=ProductionMenuSeeder --force` once. That seeder skips the entire import if any product already exists, preserving existing catalog edits. Review partial catalogs manually instead of rerunning the full `DatabaseSeeder` in production. The menu import does not confirm restaurant prices.

Check `/build/manifest.json`, its two referenced `/build/assets/` URLs, `/images/logo/logo.png`, and `/speisekarte` on the public domain after deployment. A new Git commit can trigger Railway redeployment; confirm the deployment completed before checking the site.
