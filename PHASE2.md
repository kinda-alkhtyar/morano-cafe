# MORANO+ Phase 2: design system and homepage

Implemented 14 November 2026 in the existing Laravel project. Phase 1 backend, Filament, MySQL setup, original logo, image files, references, and Flask workspace were preserved. No ordering, checkout, payments, customer accounts, or full internal-page redesign was added.

## Design and implementation

- The five supplied references and every original public image were inspected. The homepage follows their forest green, warm gold, cream, café photography, and editorial typography direction.
- The hero uses the intact `images/hero/hero.png` scene with responsive crop and a readability overlay. Its image is preloaded and marked high priority.
- Shared Blade components: `site-nav`, `site-footer`, `section-heading`, `action-link`, `product-card`, and `offer-card`.
- Homepage sections: hero, editorial introduction, menu category preview, featured products, current offers, about, atmosphere, visit/contact, and footer.
- Categories, featured products, and active offers are read from existing models. Product and offer sections are hidden when empty. The empty-database category preview uses existing photography with broad descriptive labels, with no invented products or prices.
- CSS defines color, type, spacing, layout, button, card, focus, and responsive rules. Breakpoints cover phone, tablet, and desktop widths.
- GSAP adds hero entrance and subtle image movement, pointer parallax on fine-pointer devices, scroll reveals, and magnetic button motion. CSS handles image hover and navigation transitions. `prefers-reduced-motion` skips GSAP effects and disables smooth scrolling. Content is visible without JavaScript.
- The mobile menu supports keyboard focus, Escape, outside click, and active states.
- The actual exterior asset is `images/cafe/cafe-exterio.png`; the brief's `cafe-exterior.png` does not exist.

## Modified files

- `app/Http/Controllers/PageController.php`
- `resources/views/layouts/app.blade.php`
- `resources/views/pages/home.blade.php`
- `resources/views/components/{site-nav,site-footer,section-heading,action-link,product-card,offer-card}.blade.php`
- `resources/css/app.css`
- `resources/js/app.js`
- `tests/Feature/PublicRoutesTest.php`

## Verification

- `npm.cmd run build`: passed, no build warnings after the CSS font import was moved to the document head.
- `php vendor/bin/phpunit`: 7 tests, 34 assertions passed. Tests cover database-backed homepage content and the empty-catalog category preview.
- `php artisan view:cache`: passed.
- Live homepage HTTP response: 200. All referenced static image paths exist.
- Browser visual inspection, viewport checks at 375/390/768/1024/1440/1920, animation observation, reduced-motion interaction, and console inspection remain **unverified** because the browser access host was unavailable. Responsive behavior was implemented with CSS breakpoints but must be visually reviewed in a browser before presentation approval.

## Remaining for owner review

- Review the homepage visually on desktop and mobile and approve the Phase 2 design.
- Add verified catalog records and contact details when available; the current database has no catalog content.
- Review legal copy before public launch. Phase 3 has not started.

## Homepage refinement (14 November 2026)

- Scanned `static/images/products` and `public/images` recursively. The newly added food images were in the original `static/` tree, so 21 new PNGs were copied byte-for-byte into matching Laravel `public/images/products/{snacks,salads,sandwiches,keks}` paths. The original files were preserved. All 25 product image hashes match; no executable file was copied into `public/images`.
- Reduced the shared section spacing from 80–160px to 60–110px (roughly 25–31% less), tightened the hero, intro, about, visit, and footer, and adjusted responsive grids.
- Category cards now clearly show Pinsa, Salate, Sandwiches, and Desserts with distinct matching images. The Highlights preview uses four other matching images. The coffee-and-cake section uses the existing dedicated photo and makes no discount claim. The atmosphere section is now text-led and no longer repeats the hero photograph.
- Featured product names and prices remain database-driven. The local database still contains zero categories, products, and offers; therefore the preview shows category labels and no unverified product prices. Once staff enter featured products with valid image paths, their names and EUR prices replace the preview. The query favors distinct categories.
- Coffee, matcha, and cold-drink product folders are empty. No substitute food photos were presented as those drinks.
- Hero motion was slowed and constrained; its continuous zoom pauses when offscreen. Pointer motion remains limited to fine-pointer devices, and reduced-motion support is preserved. The fixed navigation still switches to a solid background after scrolling.
- `npm.cmd run build`, Blade compilation, JavaScript syntax check, and PHPUnit passed. Live `/`, `/speisekarte`, `/angebote`, and `/admin/login` returned 200. Browser visual, viewport, sticky-nav, animation, and console inspection could not run because the browser access host was unavailable. These remain visual approval checks.
