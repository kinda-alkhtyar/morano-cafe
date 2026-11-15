@extends('layouts.app')
@section('content')
<div class="editorial-page legal-page">
    <header class="editorial-header container-wide"><p class="eyebrow">{{ \App\Support\Locale::text('MORANO+ · Wien') }}</p><h1>{{ \App\Support\Locale::text($title) }}</h1></header>
    <section class="container-wide legal-copy" aria-label="{{ $title }}">
        @if($content)<div class="legal-text">{{ $content }}</div>
        @else<p>{{ \App\Support\Locale::text('Die rechtlich geprüften Angaben werden vor der Veröffentlichung ergänzt.') }}</p>@endif
    </section>
</div>
@endsection
