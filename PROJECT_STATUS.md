# MORANO+ project status

Updated 15 November 2026.

## Completed phases

- **Phase 1 — Laravel foundation:** Laravel 12, MySQL migrations, Filament 4 admin panel, category/product/offer/allergen models and resources, verified admin access, public routes, and image storage.
- **Phase 2 — homepage design:** Responsive homepage, shared Blade components, supplied imagery, category and featured content previews, GSAP motion, accessible mobile navigation, and reduced-motion handling.
- **Homepage dynamic content foundation:** Six category slots persist through a migration; the homepage content record stores editable text, images, address, hours, and contact fields. Featured products and current offers come from the catalog. Filament provides homepage content editing. Empty states avoid invented prices and offers.

## Current architecture

`PageController` reads Eloquent models and renders Blade pages. MySQL stores catalog and homepage content. Filament resources under `app/Filament/Resources/` manage content for verified admins. Vite builds CSS and JavaScript; source images live under `public/images/`. The menu and offers pages use the same catalog models. About and contact use the editable homepage content record; imprint and privacy still need owner-reviewed legal content.

## Verification

- Latest local PHPUnit run on 15 November 2026: **16 tests passed, 114 assertions**. Production Vite build and Blade view cache passed.
- Browser visual verification is **outstanding**. Check desktop and mobile viewports, sticky navigation, animations, reduced-motion behavior, and browser console before design approval or release.

## Pending tasks

1. Complete the outstanding visual review without changing the approved design unless the owner requests a correction.
2. Enter and verify real catalog records, offers, business contact details, and opening hours in Filament. Review uploaded images and public presentation.
3. Complete imprint and privacy pages with owner-reviewed legal text before launch.
4. Re-run tests and asset build after future changes; perform browser and accessibility checks before release.

## Resume

Follow the setup commands in [README.md](README.md). Start MySQL, check local `.env` values, run migrations and the Vite build, then use `php artisan serve --host=127.0.0.1 --port=8000`. Use `php vendor/bin/phpunit` for tests. The admin login is `/admin/login`; `php artisan morano:create-admin` creates the first admin interactively. Keep `.env`, credentials, keys, dependencies, and generated assets out of Git.

## Phase 3 — Dynamic Menu (15 November 2026)

- Imported the 37 remaining source drink PNGs as **35 unique WebP files** (14 coffee, 7 matcha/punsch, 14 cold drinks). Two byte-identical Red Bull copies were skipped. Source PNGs remain untouched; no executable files were imported. WebP output totals 4.21 MiB, compared with 46.89 MiB for the 35 source PNGs, at quality 88. All outputs have valid WebP headers.
- Added a migration for nullable website prices, separate Wolt reference prices, ingredients, and the reference URL. `MenuSeeder` imports **60 identifiable product records** across the six existing homepage categories. It can run repeatedly without creating duplicates and leaves existing owner edits intact. The six featured records are real imported products. Homepage category tiles link to menu filters.
- Built the responsive menu with category filtering, live search, equal square-image cards, product detail dialogs, missing-image placeholders, and the existing site's restrained GSAP reveals. The existing homepage design remains in place.
- Product and category management continues in the existing Filament resources. Product editing now includes ingredients and both price fields alongside existing images, allergens, availability, featured status, and sort order.
- Local migration ran. Seeder ran twice successfully. Production Vite build passed. Blade view cache passed. PHPUnit passed: **12 tests, 79 assertions**.

### Data and approval still pending

- All imported Wolt amounts are stored as **reference prices only** (59 of 60 products). The public website price is null for all 60 until the owner confirms it; Phase 3.1 hides missing prices rather than showing repeated placeholder text. Wolt bundles and the conflicting Tacchino listings must not silently become website prices.
- Wolt provides no clear description or ingredients for some products. Short factual German summaries were entered where the listing supports them: 41 of 60 products have descriptions, 16 have explicit ingredient lists. Missing fields remain empty. Allergens were not inferred and await owner verification.
- Some source drink images have no clear current Wolt match and were imported as image assets only. Additional Wolt products lack supplied images. The source `veganer-salat (1).png` retains its earlier filename; the new drink WebPs have normalized names.
- **Visual approval remains outstanding.** Review menu layout, imagery, category filters, search, dialogs, responsive behavior, reduced motion, and browser console. Check image-to-product matches, especially Caprese and Tacchino, before publishing.
- No cart, checkout, orders, or payment work was added. Phase 3 changes are local and have not been pushed.

## Phase 3.1 — Menu polish (15 November 2026)

- Reduced menu header and vertical spacing, made cards more compact while keeping square images, and made filters sticky under the fixed navigation. Added six drink subgroups: Kaffee, Iced Coffee, Milkshakes, Matcha, Punsch & Heißgetränke, and Softdrinks. The six homepage categories and approved hero remain unchanged.
- Hid repeated missing-price and missing-description messages. Cleaned imported German product names and volume formatting without changing owner-edited names. Hid the Highlights scrollbar while retaining arrows. Hid the public homepage offers section when no current offers exist; Filament offers management remains available.
- The hot Matcha image was flagged for replacement and was not shown in Phase 3.1. Phase 4 resolves that flag with the supplied replacement.
- Production build passed; PHPUnit passed **14 tests, 96 assertions**. Browser visual and interaction approval remained outstanding because the browser access host was unavailable.

## Phase 4 — Inner pages and verified business details (15 November 2026)

- Converted the supplied replacement `../static/images/products/matcha/matcha-latte-hot.png` to a 1200 × 1200 WebP (168,368 bytes), updated the hot Matcha product image path, and cleared its image-review flag. The original PNG remains untouched.
- Completed Über uns, Kontakt, and Angebote pages using the existing design language, editable homepage content, and live active offers. About text and image remain editable. Empty offers have a clear state; no offer is invented.
- Seeded the **address and phone listed on MORANO+’s [Wolt page](https://wolt.com/de-at/aut/vienna/restaurant/morano)** only when those fields were blank: Taborstraße 53-55/1/R02, 1020 Wien; +43 660 160 5353. Both remain editable in Filament. Added editable Instagram, Facebook, and TikTok links, displayed only when valid URLs are entered. The map embed remains editable; an address-based Google Maps search link is available while no verified embed URL is set.
- Wolt labels its schedule as **delivery times**. Café opening hours remain blank pending owner confirmation. No email or social account was guessed. The contact page and footer hide absent details.
- Added route-specific page titles, descriptions, canonical and Open Graph metadata, focus-visible support, external-link announcements, and responsive inner-page layouts. Unreviewed legal placeholders are marked `noindex`.
- Migration and idempotent seeder ran; production Vite build and Blade view cache passed. PHPUnit passed **16 tests, 114 assertions**. The Matcha image path and business fields were verified in the local database. No ordering, checkout, payment work, or GitHub push.

### Approval still needed

- Review About, Contact, Offers, the menu, and homepage at desktop and mobile sizes, including keyboard navigation, dialogs, sticky filters, reduced motion, and browser console. Browser visual verification remains outstanding.
- Confirm café opening hours, email, map embed URL, and any official social accounts before publishing them. Confirm website prices, allergens, remaining menu details, and legal text before launch.

## Published business information and marketplace references (15 November 2026)

- The editable business record now contains the supplied MORANO+ address and phone, plus direct [Wolt](https://wolt.com/de-at/aut/vienna/restaurant/morano), [Foodora](https://www.foodora.at/restaurant/bwtv/morano), and [NeoTaste](https://neotaste.com/gb/restaurants/vienna/morano-plus) links. The homepage and contact page embed an address-based interactive Google map and provide a directions link. No guessed email, social account, or legal details were added.
- [NeoTaste](https://neotaste.com/gb/restaurants/vienna/morano-plus) lists Monday–Saturday 08:00–23:59 and Sunday 08:00–17:00. These hours are stored with their source and a **provisional** flag, displayed with a verification notice, and editable in Filament. Wolt labels its different hours as delivery times; Foodora's listing has still different service hours. Neither was used as café opening hours. Owner confirmation remains necessary.
- Two published NeoTaste deals are stored idempotently: **2 für 1 Hauptgericht** (the cheaper or equally priced main course is free) and **40 % Rabatt** (whole bill). Both are for on-site redemption through the NeoTaste app. A valid membership, advance deal/time-slot booking, presentation when ordering, and app redemption before payment are required by [NeoTaste terms](https://neotaste.com/at/agb). The listing shows “90 days” but does not make its meaning sufficiently clear for a public restriction, so it is left to NeoTaste's linked current terms. No euro offer price was invented.
- The catalog seeder updates reference amounts for exact named Foodora matches, excluding temporary discounted amounts. It leaves official `price` null. The menu visibly labels reference prices and warns that restaurant prices require confirmation. Exact Wolt matches with explicit allergen codes gained only those codes; allergens for other products remain pending. No product records or images were removed.
- **Source conflicts:** Foodora's Pinsa listing includes a drink at €10.90, while the existing Wolt menu records are bundled differently and show other prices. Those are not treated as exact price matches. Wolt has conflicting Tacchino spellings/prices. Foodora currently lists hot Matcha at €6.00 and iced Matcha at €6.40, different from earlier Wolt references (€5.50 and €4.40). Foodora's discounted dessert and Caramel Macchiato amounts are promotions; their regular listed amounts were used. Foodora and Wolt sometimes differ in ingredients or product composition, especially salads and sandwiches; existing descriptions were preserved rather than merging mismatched listings. Confirm all final restaurant prices and ambiguous products with the owner.
- Migration and seeder ran successfully. PHPUnit: **18 tests, 137 assertions passed**. Production Vite build passed. Desktop/mobile browser visual verification and external map rendering remain outstanding. Changes remain local; no GitHub push was made.
