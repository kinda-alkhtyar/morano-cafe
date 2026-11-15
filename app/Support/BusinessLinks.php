<?php

namespace App\Support;

use App\Models\HomepageContent;

final class BusinessLinks
{
    public static function map(?HomepageContent $content): ?string
    {
        if (blank($content?->address)) return null;
        return 'https://www.google.com/maps/search/?api=1&query='.rawurlencode(str_replace("\n", ', ', $content->address));
    }

    public static function mapEmbed(?HomepageContent $content): ?string
    {
        if (str_starts_with($content?->map_embed_url ?? '', 'https://www.google.com/maps/embed?')) return $content->map_embed_url;
        if (blank($content?->address)) return null;
        return 'https://maps.google.com/maps?q='.rawurlencode(str_replace("\n", ', ', $content->address)).'&output=embed';
    }

    public static function marketplaces(?HomepageContent $content): array
    {
        $sites = ['Wolt' => ['wolt_url', 'https://wolt.com/'], 'Foodora' => ['foodora_url', 'https://www.foodora.at/'], 'NeoTaste' => ['neotaste_url', 'https://neotaste.com/']];
        $links = [];
        foreach ($sites as $label => [$field, $prefix]) {
            $url = $content?->{$field};
            if (is_string($url) && str_starts_with($url, $prefix)) $links[$label] = $url;
        }
        return $links;
    }

    public static function socials(?HomepageContent $content): array
    {
        $sites = [
            'Instagram' => ['instagram_url', 'https://www.instagram.com/'],
            'Facebook' => ['facebook_url', 'https://www.facebook.com/'],
            'TikTok' => ['tiktok_url', 'https://www.tiktok.com/'],
        ];
        $links = [];
        foreach ($sites as $label => [$field, $prefix]) {
            $url = $content?->{$field};
            if (is_string($url) && str_starts_with($url, $prefix)) $links[$label] = $url;
        }
        return $links;
    }
}
