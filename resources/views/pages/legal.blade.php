@extends('layouts.app')
@section('content')
<div class="editorial-page legal-page">
    <header class="editorial-header container-wide"><p class="eyebrow">MORANO+ · Wien</p><h1>{{ $title }}</h1></header>
    <section class="container-wide legal-copy" aria-label="{{ $title }}">
        @if($content)<div class="legal-text">{{ $content }}</div>
        @else<p>Die rechtlich geprüften Angaben werden vor der Veröffentlichung ergänzt.</p>@endif
    </section>
</div>
@endsection
