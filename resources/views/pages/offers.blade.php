@extends('layouts.app')
@section('content')
<div class="editorial-page">
    <header class="editorial-header container-wide" data-reveal>
        <p class="eyebrow">MORANO+ · Wien</p>
        <h1>Aktuelle Angebote</h1>
        <p>@if($offers->isNotEmpty())Entdecke unsere veröffentlichten Angebote. Die Einlösung erfolgt zu den angegebenen Bedingungen.@elseAktuelle Angebote findest du hier, sobald sie veröffentlicht sind.@endif</p>
    </header>
    <section class="container-wide offers-page-list" aria-label="Angebote">
        @forelse($offers as $offer)
            <x-offer-card :offer="$offer" />
        @empty
            <div class="offers-page-empty"><p>Derzeit sind keine Angebote veröffentlicht.</p><x-action-link :href="route('menu')" secondary>Zur Speisekarte</x-action-link></div>
        @endforelse
    </section>
</div>
@endsection
