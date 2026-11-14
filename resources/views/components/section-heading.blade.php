@props(['eyebrow', 'title', 'text' => null, 'light' => false, 'titleId' => null])
<div {{ $attributes->class(['section-heading', 'section-heading-light' => $light]) }}><p class="eyebrow">{{ $eyebrow }}</p><h2 @if($titleId) id="{{ $titleId }}" @endif>{{ $title }}</h2>@if($text)<p class="section-intro">{{ $text }}</p>@endif</div>
