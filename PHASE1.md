# MORANO+ Phase 1: completed foundation

Completed locally on 14 November 2026. This Laravel application lives in `morano-cafe/`; the original Flask workspace, `static/`, `references/`, and all original images remain at the workspace root. The nine public image copies remain in `public/images/`.

## Installed and configured

- PHP 8.3.36, Composer 2.10.3, MySQL 8.4.3, Node.js 24.18.0, npm 11.16.0.
- Laravel 12.72.0 and Filament 4.16.3 installed with lockfiles. Laragon PHP's installed ZIP extension was enabled in `C:\laragon\bin\php\php-8.3.36-Win32-vs16-x64\php.ini` for Filament.
- Standard Laravel `config/`, `storage/`, and `bootstrap/cache/` directories completed from a temporary Laravel 12 skeleton. The temporary skeleton was removed.
- Local `.env` generated with an application key and a dedicated `morano_app` MySQL user with a random password. The password stays in ignored `.env`; it is not recorded here. Database `morano_cafe` was created and both migrations ran.
- Public storage link created. Filament admin panel and category, product, offer, and allergen resources installed. Catalog changes require a verified admin. Image uploads use the public disk, accept JPEG/PNG/WebP, and are limited to 5 MB. Prices are integer EUR cents.
- No public registration route, seeded admin, online ordering, checkout, or payments.

## Run locally

Start Laragon's MySQL service, then in PowerShell:

```powershell
cd C:\Users\kinda\Desktop\morano-cafe\morano-cafe
php artisan serve --host=127.0.0.1 --port=8000
```

Open **http://127.0.0.1:8000/**. Admin login: **http://127.0.0.1:8000/admin/login**. To create the first admin after verifying who should own it, run `php artisan morano:create-admin` interactively and enter a unique email and a password of at least 12 characters. No credential is generated or published automatically.

For a fresh install using the existing `.env` and database, run:

```powershell
composer install
php artisan migrate
php artisan storage:link
npm.cmd install
npm.cmd run build
php vendor/bin/phpunit
```

## Verification

- MySQL migrations: 2 ran successfully.
- `npm.cmd run build`: successful; generated Vite assets.
- `php vendor/bin/phpunit`: 5 tests, 22 assertions passing, including all public routes, admin password login, no registration, and verified admin access control. This lean scaffold does not provide `php artisan test`; use PHPUnit directly.
- Live HTTP check on port 8000: `/`, `/speisekarte`, `/angebote`, `/ueber-uns`, `/kontakt`, `/impressum`, `/datenschutz`, `/admin/login`, and `/up` returned 200; unauthenticated `/admin` redirected to login.

The public pages remain Phase 1 placeholders. Menu and offers are empty until staff enter catalog records. Legal text still needs owner review before public launch. Homepage design and Phase 2 work have not begun.

