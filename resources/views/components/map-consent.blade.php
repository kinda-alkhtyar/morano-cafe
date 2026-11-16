@props(['content', 'title' => 'Karte: MORANO+ in Wien'])
@if(\App\Support\BusinessLinks::mapEmbed($content))
    <div class="map-consent" data-map-consent>
        <p>{{ \App\Support\Locale::text('Die interaktive Karte wird von Google Maps geladen. Dabei können Daten an Google übertragen werden.') }}</p>
        <button type="button" class="map-load-button" data-map-load data-map-src="{{ \App\Support\BusinessLinks::mapEmbed($content) }}" data-map-title="{{ \App\Support\Locale::text($title) }}">{{ \App\Support\Locale::text('Karte laden') }}</button>
        @if(\App\Support\BusinessLinks::map($content))<a href="{{ \App\Support\BusinessLinks::map($content) }}" target="_blank" rel="noopener noreferrer">{{ \App\Support\Locale::text('Route in Google Maps öffnen') }}<span class="sr-only">{{ \App\Support\Locale::text('(öffnet in neuem Tab)') }}</span></a>@endif
    </div>
@endif
