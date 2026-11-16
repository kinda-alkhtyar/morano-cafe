@extends('layouts.app')
@section('content')
<div class="editorial-page">
    <header class="editorial-header container-wide" data-reveal>
        <p class="eyebrow">{{ \App\Support\Locale::text('MORANO+ · Wien') }}</p>
        <h1>{{ \App\Support\Locale::text('Über uns') }}</h1>
        <p>{{ \App\Support\Locale::text('Ein Ort für Kaffee, Kuchen und eine kleine Pause in der Leopoldstadt.') }}</p>
    </header>
    <section class="container-wide editorial-split" aria-labelledby="about-story-title">
        <div class="editorial-image" data-reveal>
            @if(\App\Support\ImageUrl::exists($content->about_image) && $content->about_image !== 'offers/coffee-cake.webp')<img src="{{ \App\Support\ImageUrl::for($content->about_image) }}" alt="{{ \App\Support\Locale::text('Einblick in MORANO+') }}" loading="lazy" decoding="async" width="960" height="720">
            @elseif(\App\Support\ImageUrl::exists('cafe/coffee-machine.png'))<img src="{{ asset('images/cafe/coffee-machine.png') }}" alt="{{ \App\Support\Locale::text('Kaffeebar im MORANO+') }}" loading="lazy" decoding="async" width="960" height="720">
            @else<span class="brand-placeholder" aria-hidden="true"><span>MORANO<span class="brand-plus">+</span></span></span>@endif
        </div>
        <div class="editorial-copy" data-reveal>
            <p class="eyebrow">{{ \App\Support\Locale::text('Unser Café') }}</p>
            <h2 id="about-story-title">{{ \App\Support\Locale::text('Willkommen im MORANO+.') }}</h2>
            @if($content->about_text)<p>{{ \App\Support\Locale::text($content->about_text) }}</p>@else<p>{{ \App\Support\Locale::text('Bei uns in der Leopoldstadt findest du Kaffee, Kuchen und kleine Speisen. Ob du kurz vorbeischaust oder länger bleibst: Wir freuen uns auf deinen Besuch.') }}</p>@endif
            <x-action-link :href="route('menu')">{{ \App\Support\Locale::text('Speisekarte entdecken') }}</x-action-link>
        </div>
    </section>
</div>
@endsection
