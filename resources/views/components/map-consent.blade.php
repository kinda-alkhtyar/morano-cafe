@props(['content', 'title' => 'Karte: MORANO+ in Wien'])
@if(\App\Support\BusinessLinks::mapEmbed($content))
    <div class="map-consent" data-map-consent>
        <p>Die interaktive Karte wird von Google Maps geladen. Dabei können Daten an Google übertragen werden.</p>
        <button type="button" class="map-load-button" data-map-load data-map-src="{{ \App\Support\BusinessLinks::mapEmbed($content) }}" data-map-title="{{ $title }}">Karte laden</button>
        @if(\App\Support\BusinessLinks::map($content))<a href="{{ \App\Support\BusinessLinks::map($content) }}" target="_blank" rel="noopener noreferrer">Route in Google Maps öffnen <span class="sr-only">(öffnet in neuem Tab)</span></a>@endif
    </div>
@endif
