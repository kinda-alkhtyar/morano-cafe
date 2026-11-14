@extends('layouts.app')
@section('content')
<section class="hero" aria-labelledby="hero-title" data-hero>
    <div class="hero-media" data-hero-media><img src="{{ asset('images/hero/hero.png') }}" alt="Gäste im MORANO+ Café" width="1672" height="941" fetchpriority="high"></div>
    <div class="hero-shade"></div>
    <div class="container-wide hero-content">
        <p class="hero-overline" data-hero-line><span class="gold-rule"></span> Café & Restaurant · Wien</p>
        <h1 id="hero-title" data-hero-line>Dein Kaffee.<br>Dein Moment.<br><em>Dein Morano.</em></h1>
        <p class="hero-copy" data-hero-line>Ein Ort zum Ankommen, Genießen und Bleiben. Entdecke MORANO+ in Wien.</p>
        <div class="hero-actions" data-hero-line><x-action-link :href="route('menu')">Speisekarte entdecken</x-action-link><x-action-link :href="route('offers')" secondary light>Angebote entdecken</x-action-link></div>
    </div>
    <div class="hero-foot container-wide"><span>Ein Moment mehr für dich</span><a href="#entdecken">Weiter entdecken <span aria-hidden="true">↓</span></a></div>
</section>

<section class="intro-section section-pad" id="entdecken" aria-labelledby="intro-title">
    <div class="container-wide intro-grid">
        <div data-reveal><p class="eyebrow">Willkommen bei MORANO+</p><h2 id="intro-title" class="display-heading">Ein guter Moment<br>beginnt <em>hier.</em></h2></div>
        <div class="intro-side" data-reveal><p>Manche Orte laden zum Verweilen ein. Bei MORANO+ treffen Kaffeeduft, gutes Essen und eine Atmosphäre aufeinander, in der du einfach bleiben möchtest.</p><span class="small-rule"></span><span class="intro-caption">Mitten in Wien. Ganz bei dir.</span></div>
    </div>
</section>

<section class="category-section section-pad" aria-labelledby="category-title">
    <div class="container-wide">
        <div class="section-top" data-reveal><x-section-heading eyebrow="Die Auswahl" title="Für jeden Moment." title-id="category-title" text="Entdecke Pinsa, Salate, Sandwiches und Desserts." /><x-action-link :href="route('menu')" secondary>Zur Speisekarte</x-action-link></div>
        <div class="category-grid">
            @php
                $categoryImages = [
                    ['name' => 'Pinsa', 'path' => 'products/snacks/pinsa-margherita.png'],
                    ['name' => 'Salate', 'path' => 'products/salads/caesar-salat.png'],
                    ['name' => 'Sandwiches', 'path' => 'products/sandwiches/sandwich-gegrilltes-gemuese.png'],
                    ['name' => 'Desserts', 'path' => 'products/keks/new-york-cheesecake.png'],
                ];
            @endphp
            @foreach($categoryImages as $categoryImage)
                <a href="{{ route('menu') }}" class="category-tile" data-reveal>
                    <img src="{{ asset('images/' . $categoryImage['path']) }}" alt="" loading="lazy" width="1024" height="1024">
                    <span class="category-overlay"><span class="category-number">0{{ $loop->iteration }}</span><span class="category-name">{{ $categoryImage['name'] }}</span><span class="category-arrow" aria-hidden="true">↗</span></span>
                </a>
            @endforeach
        </div>
    </div>
</section>

<section class="featured-section section-pad" aria-labelledby="featured-title">
    <div class="container-wide">
        <div class="section-top" data-reveal><x-section-heading eyebrow="Unsere Highlights" title="Ein Blick auf die Auswahl." title-id="featured-title" text="Vier Facetten von MORANO+ – von herzhaft bis süß." /><x-action-link :href="route('menu')" secondary>Speisekarte ansehen</x-action-link></div>
        @if($featured->isNotEmpty())
            <div class="product-grid">@foreach($featured as $product)<x-product-card :product="$product" />@endforeach</div>
        @else
            <div class="highlight-grid" aria-label="Einblicke in unsere Speisen">
                @foreach([
                    ['category' => 'Pinsa', 'image' => 'products/snacks/pinsa-vegan.png'],
                    ['category' => 'Salate', 'image' => 'products/salads/garnelen-salat.png'],
                    ['category' => 'Sandwiches', 'image' => 'products/sandwiches/sandwich-thunfisch.png'],
                    ['category' => 'Desserts', 'image' => 'products/keks/tiramisu.png'],
                ] as $highlight)
                    <a href="{{ route('menu') }}" class="highlight-card" data-reveal><span class="highlight-image"><img src="{{ asset('images/' . $highlight['image']) }}" alt="" loading="lazy" width="1024" height="1024"></span><span class="highlight-meta"><span>{{ $highlight['category'] }}</span><span aria-hidden="true">↗</span></span></a>
                @endforeach
            </div>
            <p class="catalog-note">Produktnamen und Preise erscheinen hier, sobald die Speisekarte im System gepflegt ist.</p>
        @endif
    </div>
</section>

<section class="coffee-promo section-pad" aria-labelledby="coffee-title">
    <div class="container-wide coffee-grid">
        <div class="coffee-copy" data-reveal><p class="eyebrow">Eine kleine Pause</p><h2 id="coffee-title">Kaffee & Kuchen.<br><em>Einfach genießen.</em></h2><p>Für den Moment zwischendurch oder einen Nachmittag, der ein bisschen länger dauert.</p><x-action-link :href="route('menu')">Speisekarte entdecken</x-action-link></div>
        <div class="coffee-visual" data-reveal><img src="{{ asset('images/offers/coffee-cake.webp') }}" alt="Kaffee und Kuchen bei MORANO+" loading="lazy" width="1536" height="1024"></div>
    </div>
</section>

@if($offers->isNotEmpty())
<section class="offers-section section-pad" aria-labelledby="offers-title"><div class="container-wide"><div class="section-top" data-reveal><x-section-heading eyebrow="Für deinen nächsten Besuch" title="Aktuelle Angebote" title-id="offers-title" /><x-action-link :href="route('offers')" secondary>Alle Angebote</x-action-link></div><div class="offer-grid">@foreach($offers as $offer)<x-offer-card :offer="$offer" />@endforeach</div></div></section>
@endif

<section class="story-section section-pad" aria-labelledby="story-title">
    <div class="container-wide story-grid"><div class="story-photo" data-reveal><img src="{{ asset('images/cafe/coffee-machine.png') }}" alt="Kaffeebar bei MORANO+" loading="lazy" width="1536" height="1024"></div><div class="story-copy" data-reveal><x-section-heading eyebrow="Mehr als ein Café" title="Zeit für das, was zählt." title-id="story-title" text="Ein Kaffee in Ruhe. Ein Gespräch, das länger dauert. Ein Platz zum Ankommen. MORANO+ ist für die kleinen Pausen da, die den Tag besonders machen." /><x-action-link :href="route('about')">Mehr über uns</x-action-link></div></div>
</section>

<section class="atmosphere-section" aria-labelledby="atmosphere-title">
    <div class="container-wide atmosphere-inner" data-reveal><p class="eyebrow">Die Atmosphäre</p><h2 id="atmosphere-title">Komm an.<br><em>Bleib einen Moment.</em></h2><p>Ob für eine kurze Pause oder einen langen Nachmittag – mach es dir bei uns gemütlich.</p></div>
</section>

<section class="visit-section section-pad" aria-labelledby="visit-title">
    <div class="container-wide visit-grid"><div class="visit-copy" data-reveal><x-section-heading eyebrow="Bis bald bei MORANO+" title="Wir freuen uns auf dich." title-id="visit-title" text="Entdecke den Ort hinter den Momenten. Wir sehen uns in Wien." /><x-action-link :href="route('contact')">Kontakt & Besuch</x-action-link></div><div class="visit-photo" data-reveal><img src="{{ asset('images/cafe/cafe-exterio.png') }}" alt="Außenansicht des MORANO+ Cafés" loading="lazy" width="1448" height="1086"></div></div>
</section>
@endsection
