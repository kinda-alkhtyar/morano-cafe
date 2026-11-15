<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        // Short factual summaries of the linked Wolt listing; no menu copy is reproduced verbatim.
        $descriptions = [
            'pinsa-customer-favourite' => 'Scharfe Pinsa mit Salami, Peperoni und Chiliöl.',
            'pinsa-pollo-piccante' => 'Pinsa mit Hähnchenbrust, Jalapeños und Chiliöl.',
            'pinsa-pollo' => 'Pinsa mit Hähnchenbrust, Mais und Champignons.',
            'pinsa-gamberi' => 'Pinsa mit Garnelen, Tomaten und Champignons.',
            'pinsa-tacchino' => 'Pinsa mit Putenschinken, Tomaten und Champignons.',
            'pinsa-margherita' => 'Pinsa mit Tomatensauce, Mozzarella und Basilikum.',
            'pinsa-vegan' => 'Vegane Pinsa mit Champignons, Kirschtomaten und Oliven.',
            'caesar-salat' => 'Salat mit paniertem Hühnerfleisch, Avocado und Caesar-Dressing.',
            'garnelen-salat' => 'Salat mit Garnelen, Oliven und Kräutern.',
            'veganer-salat (1)' => 'Veganer Salat mit Avocado, Kichererbsen und Kräuterdressing.',
            'high-protein-salat' => 'Salat mit Eiern, Kichererbsen und Avocado.',
            'sandwich-olivier' => 'Sandwich mit Kartoffeln, Hühnerfleisch und Mayonnaise.',
            'sandwich-thunfisch' => 'Sandwich mit Thunfisch, Salat und Gemüse.',
            'sandwich-caprese' => 'Sandwich mit Hühnerbrust, Garnelen und Mozzarella.',
            'sandwich-gegrilltes-gemuese' => 'Veganes Baguette mit Grillgemüse und Essiggurken.',
            'sandwich-morano-art' => 'Sesambrot mit Putenschinken, Salat und Kartoffelsticks.',
            'new-york-cheesecake' => 'Cremiger Cheesecake nach klassischer Art.',
            'schokoladenkuchen' => 'Saftiger Kuchen mit Schokolade.',
            'apfelstrudel' => 'Apfelstrudel mit Zimtnote.',
            'tiramisu' => 'Dessert mit Mascarpone und Kaffee-Aroma.',
            'americano' => 'Espresso mit heißem Wasser verlängert.',
            'cappuccino' => 'Espresso mit Milchschaum.',
            'caffe-latte' => 'Milchkaffee mit geschäumter Milch.',
            'flat-white' => 'Ristretto mit feinporigem Milchschaum.',
            'melange' => 'Wiener Melange mit Milchschaum.',
            'mocha' => 'Espresso mit Kakao und Milch.',
            'caramel-macchiato' => 'Espresso mit Milch und Karamellsirup.',
            'iced-latte' => 'Kalter Milchkaffee auf Eis.',
            'iced-caramel-latte' => 'Kalter Milchkaffee mit Karamellsirup.',
            'iced-mocha' => 'Gekühlter Espresso mit Schokolade und Milch.',
            'vanilla-milkshake' => 'Milchshake mit Bourbon-Vanille.',
            'chocolate-milkshake' => 'Milchshake mit Schokolade.',
            'strawberry-milkshake' => 'Milchshake mit Erdbeerpüree.',
            'hot-chocolate' => 'Heiße Schokolade mit Milch.',
            'matcha/matcha-latte-hot' => 'Heißer Latte mit Matcha.',
            'matcha/iced-matcha-latte' => 'Kalter Matcha-Latte auf Eis.',
            'matcha/lychee-matcha' => 'Iced Matcha mit Litschi und Milch.',
            'matcha/coconut-matcha' => 'Iced Matcha mit Kokosmilch.',
            'matcha/mango-matcha' => 'Iced Matcha mit Mango und Milch.',
            'matcha/apfel-zimt-punsch' => 'Warmer Apfelpunsch mit Zimt.',
            'matcha/beerenpunsch' => 'Warmer Punsch mit Beeren.',
        ];
        $cleanNames = [
            'pinsa-customer-favourite' => 'Pinsa Customer Favourite',
            'pinsa-gamberi' => 'Pinsa Gamberi',
            'sandwich-olivier' => 'Sandwich Olivier',
            'sandwich-thunfisch' => 'Thunfisch-Sandwich',
            'sandwich-caprese' => 'Caprese-Sandwich',
            'sandwich-gegrilltes-gemuese' => 'Sandwich mit gegrilltem Gemüse',
            'sandwich-morano-art' => 'Sandwich Morano Art',
            'sandwich-chef-special' => 'Sandwich Chef Special',
            'schoko-blaubeeren-kuchen' => 'Schokoladenkuchen mit Blaubeeren',
            'schoko-muffin' => 'Schoko-Muffin',
            'matcha/matcha-latte-hot' => 'Matcha Latte, heiß',
            'matcha/iced-matcha-latte' => 'Iced Matcha Latte',
            'matcha/apfel-zimt-punsch' => 'Apfel-Zimt-Punsch',
            'cold-drinks/pepsi-dose-033l' => 'Pepsi, Dose 0,33 l',
            'cold-drinks/coca-cola-dose' => 'Coca-Cola, Dose 0,33 l',
            'cold-drinks/coca-cola-flasche' => 'Coca-Cola, Flasche',
            'cold-drinks/fanta-orange-2l' => 'Fanta Orange, PET-Flasche 2 l',
            'cold-drinks/coca-cola-zero-2l' => 'Coca-Cola Zero, PET-Flasche 2 l',
            'cold-drinks/sprite-lemon-lime-1l' => 'Sprite Lemon-Lime, PET-Flasche 1 l',
            'cold-drinks/mezzo-mix-dose-033l' => 'Mezzo Mix, Dose 0,33 l',
            'cold-drinks/red-bull-white-edition-025l' => 'Red Bull White Edition, Dose 0,25 l',
            'cold-drinks/pago-marille-02l' => 'Pago Marille, Glasflasche 0,2 l',
            'cold-drinks/tropical-aloe-vera-green-tea-05l' => 'Tropical Aloe Vera Green Tea, PET-Flasche 0,5 l',
            'cold-drinks/fuze-tea-zitrone' => 'Fuze Tea Zitrone',
        ];
        $groups = [
            'pinsa' => ['snacks', [
                ['Pinsa Customer favourite Menü', 'pinsa-customer-favourite', 1490, 'Salami, Peperoni, Käse, Mais, Chiliöl, Tomatensauce'],
                ['Pinsa Pollo Piccante Menü', 'pinsa-pollo-piccante', 1490, 'Hähnchenbrust, Käse, Champignons, Mais, Jalapeños, Chiliöl'],
                ['Pinsa Pollo Menü', 'pinsa-pollo', 1450, 'Hähnchenbrust, Mais, Champignons, Tomatensauce, Basilikum, Öl'],
                ['Gamberi Menü', 'pinsa-gamberi', 1450, 'Garnelen, Tomatensauce, Käse, Champignons, Tomaten, Mais'],
                ['Pinsa Gamberi Piccante Menü', 'pinsa-gamberi-piccante', 1490],
                ['Pinsa Tacchino Menü', 'pinsa-tacchino', null, 'Putenschinken, Käse, Tomatensauce, Champignons, Tomaten, Mais'],
                ['Pinsa Margherita Menü', 'pinsa-margherita', 1290, 'Tomatensauce, Käse, Mozzarella, Basilikum'],
                ['Pinsa Vegan Menü', 'pinsa-vegan', 1390, 'Veganer Käse, Tomatensauce, Champignons, Kirschtomaten, Oliven'],
            ]],
            'salate' => ['salads', [
                ['Caesar Salat Menü', 'caesar-salat', 1390, 'Salat, paniertes Hühnerfleisch, Avocado, Kirschtomaten, Oliven, Mais, Croutons, Käse, Caesar-Dressing'],
                ['Garnelen Salat Menü', 'garnelen-salat', 1490, 'Salat, Garnelen, Kirschtomaten, grüne und schwarze Oliven, Käse, Kräuter'],
                ['Veganer Salat', 'veganer-salat (1)', 1290, 'Salat, Avocado, Kichererbsen, Gurken, Kirschtomaten, Mais, Oliven, Rotkraut, Granatapfelkerne, Kürbiskerne, veganes Kräuterdressing'],
                ['High Protein Menü', 'high-protein-salat', 1590, 'Salat, Eier, Kichererbsen, Avocado, Mais, Gurken, Kirschtomaten, Rotkraut, Kerne, Kräuterdressing'],
            ]],
            'sandwiches' => ['sandwiches', [
                ['Sandwich Olivier Menü', 'sandwich-olivier', 1490, 'Kartoffeln, Eier, Hühnerfleisch, Erbsen, Gewürzgurken, Mayonnaise, Sandwichbrot'],
                ['Thunfisch Sandwich Menü', 'sandwich-thunfisch', 1490, 'Thunfisch, Salat, Tomaten, Gurken, Sauce, Sandwichbrot'],
                ['Caprese Sandwich Menü', 'sandwich-caprese', 1690, 'Hühnerbrust, Garnelen, Mozzarella, Tomaten, Basilikum, Salat, Sandwichbrot'],
                ['Gegrilltes Gemüse Menü', 'sandwich-gegrilltes-gemuese', 1490, 'Baguette, veganer Käse, Grillgemüse, Tomaten, Essiggurken, vegane Sauce'],
                ['Morano Art Menü', 'sandwich-morano-art', 1290, 'Sesambrot, Putenschinken, Salat, Tomaten, Gewürzgurken, Kartoffelsticks, Sauce'],
                ['Chef Special Menü', 'sandwich-chef-special', 1590],
            ]],
            'desserts' => ['keks', [
                ['New York Cheesecake', 'new-york-cheesecake', 490],
                ['Schokoladenkuchen', 'schokoladenkuchen', 340],
                ['Apfelstrudel', 'apfelstrudel', 320],
                ['Schokoladen Kuchen mit Blaubeeren', 'schoko-blaubeeren-kuchen', 320],
                ['Schoko Muffin', 'schoko-muffin', 380],
                ['Tiramisu', 'tiramisu', 600],
                ['Profiteroles', 'profiteroles', 390],
            ]],
            'kaffee' => ['coffee', [
                ['Americano', 'americano', 390], ['Cappuccino', 'cappuccino', 450],
                ['Caffè Latte', 'caffe-latte', 490], ['Flat White', 'flat-white', 490],
                ['Melange', 'melange', 470], ['Mocha', 'mocha', 520],
                ['Caramel Macchiato', 'caramel-macchiato', 550],
                ['Iced Latte', 'iced-latte', 550], ['Iced Caramel Latte', 'iced-caramel-latte', 590],
                ['Iced Mocha', 'iced-mocha', 590], ['Vanilla Milkshake', 'vanilla-milkshake', 650],
                ['Chocolate Milkshake', 'chocolate-milkshake', 690],
                ['Strawberry Milkshake', 'strawberry-milkshake', 690], ['Hot Chocolate', 'hot-chocolate', 500],
            ]],
            'drinks' => [null, [
                ['Matcha Latte - Hot', 'matcha/matcha-latte-hot', 550],
                ['Iced Matcha Latte - Cold', 'matcha/iced-matcha-latte', 440],
                ['Lychee Matcha', 'matcha/lychee-matcha', 590],
                ['Coconut Matcha', 'matcha/coconut-matcha', 590],
                ['Mango Matcha', 'matcha/mango-matcha', 590],
                ['Apfel Zimt Punsch', 'matcha/apfel-zimt-punsch', 390],
                ['Beerenpunsch', 'matcha/beerenpunsch', 390],
                ['Pepsi Dose 0,33l Retail', 'cold-drinks/pepsi-dose-033l', 320],
                ['Pepsi Zero Dose', 'cold-drinks/pepsi-zero-dose', 320],
                ['Coca-Cola Dose 0,33l DE', 'cold-drinks/coca-cola-dose', 320],
                ['Coca Cola Flasche', 'cold-drinks/coca-cola-flasche', 380],
                ['Fanta Orange PET-Flasche 2l', 'cold-drinks/fanta-orange-2l', 380],
                ['Fanta Dose', 'cold-drinks/fanta-orange-dose', 320],
                ['Fuze tea Zitrone', 'cold-drinks/fuze-tea-zitrone', 380],
                ['Coca-Cola Zero PET-Flasche 2l', 'cold-drinks/coca-cola-zero-2l', 380],
                ['Sprite Lemon-Lime PET-Flasche 1l', 'cold-drinks/sprite-lemon-lime-1l', 380],
                ['Mezzo Mix Dose 0,33l DE', 'cold-drinks/mezzo-mix-dose-033l', 320],
                ['Red Bull Energy Drink White Edition Kokos-Blaubeere Dose 0,25l', 'cold-drinks/red-bull-white-edition-025l', 410],
                ['Red Bull normal', 'cold-drinks/red-bull-original-025l', 410],
                ['Pago Marille Glasflasche 0,2l', 'cold-drinks/pago-marille-02l', 370],
                ['Tropical Aloe Vera Green Tea Original PET-Flasche 0,5l', 'cold-drinks/tropical-aloe-vera-green-tea-05l', 370],
            ]],
        ];

        foreach ($groups as $slot => [$folder, $products]) {
            $category = Category::where('homepage_slot', $slot)->firstOrFail();
            if (!$category->image_path && $slot === 'kaffee') $category->update(['image_path' => 'products/coffee/cappuccino.webp']);
            if (!$category->image_path && $slot === 'drinks') $category->update(['image_path' => 'products/matcha/iced-matcha-latte.webp']);
            foreach ($products as $index => $item) {
                [$name, $stem, $referencePrice] = $item;
                $displayName = $cleanNames[$stem] ?? preg_replace('/ Menü$/u', '', $name);
                $path = str_contains($stem, '/') ? $stem : $folder.'/'.$stem;
                $extension = in_array($slot, ['kaffee', 'drinks']) ? 'webp' : 'png';
                $product = Product::firstOrCreate(['slug' => Str::slug($stem)], [
                    'category_id' => $category->id,
                    'name' => $displayName,
                    'description' => $descriptions[$stem] ?? null,
                    'ingredients' => $item[3] ?? null,
                    'price' => null,
                    'reference_price' => $referencePrice,
                    'reference_source' => 'https://wolt.com/de-at/aut/vienna/restaurant/morano',
                    'image_path' => 'products/'.$path.'.'.$extension,
                    'image_review_note' => null,
                    'is_available' => true,
                    'is_featured' => in_array($stem, ['pinsa-margherita', 'caesar-salat', 'sandwich-morano-art', 'new-york-cheesecake', 'cappuccino', 'matcha/iced-matcha-latte']),
                    'sort_order' => $index,
                ]);
                if ($product->description === null && isset($descriptions[$stem])) {
                    $product->update(['description' => $descriptions[$stem]]);
                }
                if ($product->name === $name && $displayName !== $name) {
                    $product->update(['name' => $displayName]);
                }
                if ($stem === 'matcha/matcha-latte-hot' && $product->image_path === null && $product->image_review_note === 'Vorhandenes Foto zeigt nicht das Produkt; Ersatzbild prüfen.') {
                    $product->update(['image_path' => 'products/matcha/matcha-latte-hot.webp', 'image_review_note' => null]);
                }
            }
        }
    }
}
