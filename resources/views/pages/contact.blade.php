@extends('layouts.app')
@section('content')
<div class="editorial-page">
    <header class="editorial-header container-wide" data-reveal>
        <p class="eyebrow">MORANO+ · Wien</p>
        <h1>Kontakt & Besuch</h1>
        <p>Hier findest du unsere bestätigten Kontaktdaten und den Weg zu uns.</p>
    </header>
    <section class="container-wide contact-layout" aria-label="Besuchsinformationen">
        <div class="contact-details" data-reveal>
            @if($content->address)<div><h2>Adresse</h2><address>{{ $content->address }}</address>
                @if(\App\Support\BusinessLinks::map($content))<a href="{{ \App\Support\BusinessLinks::map($content) }}" target="_blank" rel="noopener noreferrer">In Google Maps öffnen <span class="sr-only">(öffnet in neuem Tab)</span></a>@endif
            </div>@endif
            @if($content->phone || $content->email)<div><h2>Kontakt</h2>
                @if($content->phone)<a href="tel:{{ preg_replace('/[^+0-9]/', '', $content->phone) }}">{{ $content->phone }}</a>@endif
                @if($content->email)<a href="mailto:{{ $content->email }}">{{ $content->email }}</a>@endif
            </div>@endif
            <div><h2>Öffnungszeiten</h2>
                @if(!empty($content->hours))<dl>@foreach($content->hours as $row)<div><dt>{{ $row['label'] }}</dt><dd>{{ $row['time'] }}</dd></div>@endforeach</dl>
                @if($content->hours_provisional)<p>Vorläufige Öffnungszeiten laut <a href="{{ $content->hours_source }}" target="_blank" rel="noopener noreferrer">NeoTaste</a>. Bitte vor dem Besuch prüfen.</p>@endif
                @else<p>Die Öffnungszeiten werden hier ergänzt, sobald sie bestätigt sind.</p>@endif
            </div>
            @if(\App\Support\BusinessLinks::marketplaces($content))<div><h2>Weitere Plattformen</h2><div class="platform-links">
                @foreach(\App\Support\BusinessLinks::marketplaces($content) as $label => $url)<a href="{{ $url }}" target="_blank" rel="noopener noreferrer">{{ $label }} <span aria-hidden="true">↗</span><span class="sr-only">(öffnet in neuem Tab)</span></a>@endforeach</div>
            </div>@endif
            @if(\App\Support\BusinessLinks::socials($content))<div><h2>Social Media</h2>
                @foreach(\App\Support\BusinessLinks::socials($content) as $label => $url)<a href="{{ $url }}" target="_blank" rel="noopener noreferrer">{{ $label }} <span class="sr-only">(öffnet in neuem Tab)</span></a>@endforeach
            </div>@endif
        </div>
        <div class="contact-map" data-reveal>
            @if(\App\Support\BusinessLinks::mapEmbed($content))
                <x-map-consent :content="$content" title="Interaktive Karte: MORANO+ in Wien" />
            @else<div class="contact-map-placeholder"><span>MORANO<span class="brand-plus">+</span></span><p>Wien</p></div>@endif
        </div>
    </section>
</div>
@endsection
