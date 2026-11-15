@props(['offer'])
@php
    $fallback = str_contains($offer->title, 'Hauptgericht') ? 'products/snacks/pinsa-margherita.png' : 'products/keks/new-york-cheesecake.png';
    $image = \App\Support\ImageUrl::exists($offer->image_path) ? $offer->image_path : $fallback;
@endphp
<article class="offer-card" data-reveal>
    <div class="offer-image-frame"><img src="{{ \App\Support\ImageUrl::for($image) }}" alt="" loading="lazy" decoding="async" width="800" height="580"></div>
    <div class="offer-card-content">
        <span class="eyebrow">{{ $offer->source_url ? 'NeoTaste · vor Ort' : 'Aktuelles Angebot' }}</span>
        <h3>{{ $offer->title }}</h3>
        @if($offer->description)<p>{{ $offer->description }}</p>@endif
        @if($offer->offer_price !== null)<span class="offer-price">{{ number_format($offer->offer_price / 100, 2, ',', '.') }} €</span>@endif
        @if($offer->redemption_conditions)<details class="offer-conditions"><summary>Einlösebedingungen</summary><p>{{ $offer->redemption_conditions }}</p></details>@endif
        @if($offer->source_url)<a class="offer-cta" href="{{ $offer->source_url }}" target="_blank" rel="noopener noreferrer">Bei NeoTaste ansehen <span aria-hidden="true">↗</span><span class="sr-only">(öffnet in neuem Tab)</span></a>@endif
    </div>
</article>
