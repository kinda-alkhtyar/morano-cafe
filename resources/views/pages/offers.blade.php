@extends('layouts.app')
@section('content')
<div class="editorial-page">
    <header class="editorial-header container-wide" data-reveal>
        <p class="eyebrow">{{ \App\Support\Locale::text('MORANO+ · Wien') }}</p>
        <h1>{{ \App\Support\Locale::text('Aktuelle Angebote') }}</h1>
        <p>@if($offers->isNotEmpty()){{ \App\Support\Locale::text('Entdecke unsere veröffentlichten Angebote. Die Einlösung erfolgt zu den angegebenen Bedingungen.') }}@else{{ \App\Support\Locale::text('Aktuelle Angebote findest du hier, sobald sie veröffentlicht sind.') }}@endif</p>
    </header>
    <section class="container-wide offers-page-list" aria-label="{{ \App\Support\Locale::text('Angebote') }}">
        @forelse($offers as $offer)
            <x-offer-card :offer="$offer" />
        @empty
            <div class="offers-page-empty"><p>{{ \App\Support\Locale::text('Derzeit sind keine Angebote veröffentlicht.') }}</p><x-action-link :href="route('menu')" secondary>{{ \App\Support\Locale::text('Zur Speisekarte') }}</x-action-link></div>
        @endforelse
    </section>
</div>
@endsection
