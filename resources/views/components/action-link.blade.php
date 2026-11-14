@props(['href', 'secondary' => false, 'light' => false])
<a href="{{ $href }}" {{ $attributes->class(['action-link', 'action-link-secondary' => $secondary, 'action-link-light' => $light]) }} data-magnetic><span>{{ $slot }}</span><span class="action-arrow" aria-hidden="true">↗</span></a>
