<?php

namespace Database\Seeders;

use App\Models\Offer;
use Illuminate\Database\Seeder;

class PublishedOffersSeeder extends Seeder
{
    public function run(): void
    {
        $source = 'https://neotaste.com/gb/restaurants/vienna/morano-plus';
        $conditions = 'Nur vor Ort mit gültiger NeoTaste-Mitgliedschaft. Deal und Zeitfenster vorab in der App buchen, Buchung bei der Bestellung vorzeigen und vor dem Bezahlen in der App einlösen. Verfügbarkeit und aktuelle Bedingungen bei NeoTaste prüfen.';
        foreach ([
            ['2 für 1 Hauptgericht', 'Bei zwei Hauptgerichten nach Wahl wird das günstigere oder gleich teure Gericht nicht berechnet.'],
            ['40 % Rabatt', '40 % Rabatt auf die gesamte Rechnung.'],
        ] as [$title, $description]) {
            Offer::firstOrCreate(['title' => $title, 'source_url' => $source], [
                'description' => $description,
                'redemption_conditions' => $conditions,
                'original_price' => null,
                'offer_price' => null,
                'is_active' => true,
            ]);
        }
    }
}
