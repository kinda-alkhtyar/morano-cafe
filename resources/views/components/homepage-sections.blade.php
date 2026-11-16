<section id="entdecken" class="category-section section-pad" aria-labelledby="category-title">
    <div class="container-wide">
        <div class="section-top" data-reveal><x-section-heading eyebrow="Unsere Speisekarte" title="Worauf hast du Lust?" title-id="category-title" /><x-action-link :href="route('menu')" secondary>{{ \App\Support\Locale::text('Zur Speisekarte') }}</x-action-link></div>
        <div class="category-grid" aria-label="{{ \App\Support\Locale::text('Speisekarten-Kategorien') }}">
            @foreach($homepageCategories as $category)
                <a href="{{ route('menu') }}{{ $category['slug'] ? '#kategorie-'.$category['slug'] : '' }}" class="category-tile" data-reveal>
                    @if(\App\Support\ImageUrl::exists($category['image_path']))
                        <img src="{{ \App\Support\ImageUrl::for($category['image_path']) }}" alt="" loading="lazy" decoding="async" width="960" height="540">
                    @else
                        <span class="brand-placeholder" aria-hidden="true"><span>MORANO<span class="brand-plus">+</span></span></span>
                    @endif
                    <span class="category-overlay"><span class="category-name">{{ \App\Support\Locale::text($category['name']) }}</span><span class="category-arrow" aria-hidden="true">↗</span></span>
                </a>
            @endforeach
        </div>
    </div>
</section>

<section class="featured-section section-pad" aria-labelledby="featured-title">
    <div class="container-wide">
        <div class="section-top" data-reveal><x-section-heading eyebrow="Aus unserer Speisekarte" title="Highlights" title-id="featured-title" /><x-action-link :href="route('menu')" secondary>{{ \App\Support\Locale::text('Zur Speisekarte') }}</x-action-link></div>
        @if($featured->isNotEmpty())
            <div class="carousel-controls" aria-label="{{ \App\Support\Locale::text('Highlights durchblättern') }}"><p>{{ \App\Support\Locale::text('Weitere Highlights ansehen') }}</p><div><button type="button" data-carousel-prev aria-label="{{ \App\Support\Locale::text('Vorherige Highlights') }}">{{ \App\Support\Locale::fa() ? '→' : '←' }}</button><button type="button" data-carousel-next aria-label="{{ \App\Support\Locale::text('Weitere Highlights') }}">{{ \App\Support\Locale::fa() ? '←' : '→' }}</button></div></div>
            <div class="highlights-rail" data-carousel role="region" aria-label="{{ \App\Support\Locale::text('Highlights aus unserer Speisekarte') }}" tabindex="0">@foreach($featured as $product)<x-product-card :product="$product" />@endforeach</div>
        @else
            <p class="section-empty">{{ \App\Support\Locale::text($content->highlights_empty_text ?: 'Unsere Empfehlungen findest du in der Speisekarte.') }}</p>
        @endif
    </div>
</section>

@if($offers->isNotEmpty())
<section class="offers-section section-pad" aria-labelledby="offers-title">
    <div class="container-wide">
        <div class="section-top" data-reveal><x-section-heading eyebrow="Bei MORANO+" title="Aktuelle Angebote" title-id="offers-title" /><x-action-link :href="route('offers')" secondary>{{ \App\Support\Locale::text('Alle Angebote') }}</x-action-link></div>
        <div class="offer-grid">@foreach($offers as $offer)<x-offer-card :offer="$offer" />@endforeach</div>
    </div>
</section>
@endif

<section class="story-section section-pad" aria-labelledby="story-title">
    <div class="container-wide story-grid">
        <div class="story-photo" data-reveal>
            @if(\App\Support\ImageUrl::exists($content->about_image))
                <img src="{{ \App\Support\ImageUrl::for($content->about_image) }}" alt="{{ \App\Support\Locale::text('Einblick in MORANO+') }}" loading="lazy" decoding="async" width="960" height="720">
            @else
                <span class="brand-placeholder" aria-hidden="true"><span>MORANO<span class="brand-plus">+</span></span></span>
            @endif
        </div>
        <div class="story-copy" data-reveal><x-section-heading eyebrow="Über MORANO+" :title="$content->about_heading ?: 'Willkommen bei MORANO+.'" title-id="story-title" :text="$content->about_text" /><x-action-link :href="route('about')">{{ \App\Support\Locale::text('Über unser Café') }}</x-action-link></div>
    </div>
</section>

<section id="standort" class="location-section section-pad" aria-labelledby="location-title">
    <div class="container-wide">
        <div class="section-top" data-reveal><x-section-heading eyebrow="Besuch planen" title="Standort & Öffnungszeiten" title-id="location-title" /></div>
        <div class="location-grid">
            <div class="location-copy" data-reveal>
                @if($content->address)<address>{{ $content->address }}</address>@else<p class="section-empty">{{ \App\Support\Locale::text('Unsere Adresse wird hier in Kürze ergänzt.') }}</p>@endif
                @if(!empty($content->hours))
                    <h3>{{ \App\Support\Locale::text('Öffnungszeiten') }}</h3><dl>@foreach($content->hours as $row)<div><dt>{{ \App\Support\Locale::text($row['label']) }}</dt><dd>{{ $row['time'] }}</dd></div>@endforeach</dl>
                    @if($content->hours_provisional)<p>{{ \App\Support\Locale::text('Vorläufig laut') }} <a href="{{ $content->hours_source }}" target="_blank" rel="noopener noreferrer">NeoTaste</a> {{ \App\Support\Locale::text('· bitte vor dem Besuch prüfen.') }}</p>@endif
                @else
                    <p class="section-empty">{{ \App\Support\Locale::text('Die aktuellen Öffnungszeiten werden hier ergänzt.') }}</p>
                @endif
                @if($content->phone)<a href="tel:{{ preg_replace('/[^+0-9]/', '', $content->phone) }}">{{ $content->phone }}</a>@endif
                @if($content->email)<a href="mailto:{{ $content->email }}">{{ $content->email }}</a>@endif
                @if(\App\Support\BusinessLinks::map($content))<a href="{{ \App\Support\BusinessLinks::map($content) }}" target="_blank" rel="noopener noreferrer">{{ \App\Support\Locale::text('Karte öffnen') }}<span class="sr-only">{{ \App\Support\Locale::text('(öffnet in neuem Tab)') }}</span></a>@endif
                @foreach(\App\Support\BusinessLinks::socials($content) as $label => $url)<a href="{{ $url }}" target="_blank" rel="noopener noreferrer">{{ $label }} <span class="sr-only">{{ \App\Support\Locale::text('(öffnet in neuem Tab)') }}</span></a>@endforeach
            </div>
            @if(\App\Support\BusinessLinks::mapEmbed($content))
                <div class="location-map" data-reveal><x-map-consent :content="$content" title="Interaktive Karte: Standort von MORANO+" /></div>
            @else
                <div class="location-identity" aria-hidden="true"><span>MORANO<span class="brand-plus">+</span></span><span>{{ \App\Support\Locale::text('Wien') }}</span></div>
            @endif
        </div>
    </div>
</section>
