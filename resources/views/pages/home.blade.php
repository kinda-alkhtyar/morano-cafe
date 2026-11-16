@extends('layouts.app')
@section('content')
<section class="hero" aria-labelledby="hero-title" data-hero>
    <div class="hero-media" data-hero-media><img src="{{ asset('images/hero/hero.webp') }}" alt="{{ \App\Support\Locale::text('MORANO+ Kaffee und Kuchen') }}" width="1672" height="941" fetchpriority="high" decoding="async"></div>
    <div class="hero-shade"></div>
    <div class="container-wide hero-content">
        <p class="hero-overline" data-hero-line><span class="gold-rule"></span>{{ \App\Support\Locale::text('Café & Restaurant · Wien') }}</p>
        <h1 id="hero-title" data-hero-line>{{ \App\Support\Locale::text('Dein Kaffee.') }}<br>{{ \App\Support\Locale::text('Dein Moment.') }}<br><em>{{ \App\Support\Locale::text('Dein Morano.') }}</em></h1>
        <p class="hero-copy" data-hero-line>{{ \App\Support\Locale::text('Kaffee, etwas Süßes oder eine kleine Mahlzeit – willkommen bei MORANO+ in Wien.') }}</p>
        <div class="hero-actions" data-hero-line><x-action-link :href="route('menu')">{{ \App\Support\Locale::text('Zur Speisekarte') }}</x-action-link><x-action-link :href="route('offers')" secondary light>{{ \App\Support\Locale::text('Aktuelle Angebote') }}</x-action-link></div>
    </div>
    <div class="hero-foot container-wide"><span>{{ \App\Support\Locale::text('MORANO+ · Wien') }}</span><a href="#entdecken">{{ \App\Support\Locale::text('Unsere Auswahl') }}<span aria-hidden="true">↓</span></a></div>
</section>

@include('components.homepage-sections')
@endsection
