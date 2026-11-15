@props(['offer'])
@php
    $fallback = str_contains($offer->title, 'Hauptgericht') ? 'offers/pinsa-margherita.webp' : 'offers/new-york-cheesecake.webp';
    $image = \App\Support\ImageUrl::exists($offer->image_path) ? $offer->image_path : $fallback;
@endphp
<article class="offer-card" data-reveal>
    <div class="offer-image-frame"><img src="{{ \App\Support\ImageUrl::for($image) }}" alt="" loading="lazy" decoding="async" width="800" height="580"></div>
    <div class="offer-card-content">
        <span class="eyebrow">{{ \App\Support\Locale::text($offer->source_url ? 'NeoTaste · vor Ort' : 'Aktuelles Angebot') }}</span>
        <h3>{{ \App\Support\Locale::text($offer->title) }}</h3>
        @if($offer->description)<p>{{ \App\Support\Locale::text($offer->description) }}</p>@endif
        @if($offer->offer_price !== null)<span class="offer-price">{{ number_format($offer->offer_price / 100, 2, ',', '.') }} €</span>@endif
        @if($offer->redemption_conditions)<details class="offer-conditions"><summary>{{ \App\Support\Locale::text('Einlösebedingungen') }}</summary><p>{{ \App\Support\Locale::text($offer->redemption_conditions) }}</p></details>@endif
        @if($offer->source_url)<a class="offer-cta" href="{{ $offer->source_url }}" target="_blank" rel="noopener noreferrer">{{ \App\Support\Locale::text('Bei NeoTaste ansehen') }}<span aria-hidden="true">↗</span><span class="sr-only">{{ \App\Support\Locale::text('(öffnet in neuem Tab)') }}</span></a>@endif
    </div>
</article>
