# MORANO+ project status

Updated 15 November 2026.

## Completed phases

- **Phase 1 — Laravel foundation:** Laravel 12, MySQL migrations, Filament 4 admin panel, category/product/offer/allergen models and resources, verified admin access, public routes, and image storage.
- **Phase 2 — homepage design:** Responsive homepage, shared Blade components, supplied imagery, category and featured content previews, GSAP motion, accessible mobile navigation, and reduced-motion handling.
- **Homepage dynamic content foundation:** Six category slots persist through a migration; the homepage content record stores editable text, images, address, hours, and contact fields. Featured products and current offers come from the catalog. Filament provides homepage content editing. Empty states avoid invented prices and offers.

## Current architecture

`PageController` reads Eloquent models and renders Blade pages. MySQL stores catalog and homepage content. Filament resources under `app/Filament/Resources/` manage content for verified admins. Vite builds CSS and JavaScript; source images live under `public/images/`. The menu and offers pages use the same catalog models. About, contact, imprint, and privacy routes currently render placeholders.

## Verification

- Latest local PHPUnit run on 15 November 2026: **10 tests passed, 67 assertions**.
- Browser visual verification is **outstanding**. Check desktop and mobile viewports, sticky navigation, animations, reduced-motion behavior, and browser console before design approval or release.

## Pending tasks

1. Complete the outstanding visual review without changing the approved design unless the owner requests a correction.
2. Enter and verify real catalog records, offers, business contact details, and opening hours in Filament. Review uploaded images and public presentation.
3. Replace informational placeholders and obtain owner review of legal text before launch.
4. Re-run tests and asset build after future changes; perform browser and accessibility checks before release.

## Resume

Follow the setup commands in [README.md](README.md). Start MySQL, check local `.env` values, run migrations and the Vite build, then use `php artisan serve --host=127.0.0.1 --port=8000`. Use `php vendor/bin/phpunit` for tests. The admin login is `/admin/login`; `php artisan morano:create-admin` creates the first admin interactively. Keep `.env`, credentials, keys, dependencies, and generated assets out of Git.
