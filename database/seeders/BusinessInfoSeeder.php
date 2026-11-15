<?php

namespace Database\Seeders;

use App\Models\HomepageContent;
use Illuminate\Database\Seeder;

class BusinessInfoSeeder extends Seeder
{
    public function run(): void
    {
        // Wolt lists this address and phone for MORANO+; delivery hours are not cafe opening hours.
        // https://wolt.com/de-at/aut/vienna/restaurant/morano
        $content = HomepageContent::find(1);
        if (!$content) return;
        $updates = [];
        if (blank($content->address)) $updates['address'] = "Taborstraße 53-55/1/R02\n1020 Wien";
        if (blank($content->phone)) $updates['phone'] = '+43 660 160 5353';
        if (empty($content->hours)) {
            $updates['hours'] = [['label' => 'Montag–Samstag', 'time' => '08:00–23:59'], ['label' => 'Sonntag', 'time' => '08:00–17:00']];
            $updates['hours_provisional'] = true;
            $updates['hours_source'] = 'https://neotaste.com/gb/restaurants/vienna/morano-plus';
        }
        foreach (['wolt_url' => 'https://wolt.com/de-at/aut/vienna/restaurant/morano', 'foodora_url' => 'https://www.foodora.at/restaurant/bwtv/morano', 'neotaste_url' => 'https://neotaste.com/gb/restaurants/vienna/morano-plus'] as $field => $url) {
            if (blank($content->{$field})) $updates[$field] = $url;
        }
        if ($updates) $content->update($updates);
    }
}
