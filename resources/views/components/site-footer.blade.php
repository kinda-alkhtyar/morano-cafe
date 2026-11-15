<footer class="site-footer">
    <div class="container-wide footer-main">
        <div><a class="footer-brand" href="{{ route('home') }}"><img src="{{ asset('images/logo/logo.png') }}" alt="MORANO+" width="210" height="70"></a><p>{{ \App\Support\Locale::text('Kaffee, kleine Speisen und Zeit zum Zusammensitzen. MORANO+ in Wien.') }}</p></div>
        <nav aria-label="Footernavigation"><span class="footer-label">{{ \App\Support\Locale::text('Entdecken') }}</span><a href="{{ route('menu') }}">{{ \App\Support\Locale::text('Speisekarte') }}</a><a href="{{ route('offers') }}">{{ \App\Support\Locale::text('Angebote') }}</a><a href="{{ route('about') }}">{{ \App\Support\Locale::text('Über uns') }}</a><a href="{{ route('contact') }}">{{ \App\Support\Locale::text('Kontakt & Anfahrt') }}</a></nav>
        <div class="footer-note"><span class="footer-label">{{ \App\Support\Locale::text('MORANO+ Wien') }}</span>
            @if($business?->address)<address>{{ $business->address }}</address>@endif
            @if($business?->phone)<a href="tel:{{ preg_replace('/[^+0-9]/', '', $business->phone) }}">{{ $business->phone }}</a>@endif
            @if($business?->email)<a href="mailto:{{ $business->email }}">{{ $business->email }}</a>@endif
            @if(\App\Support\BusinessLinks::marketplaces($business))<div class="footer-platforms"><span class="footer-label">{{ \App\Support\Locale::text('Lieferplattformen & Angebote') }}</span>
                @foreach(\App\Support\BusinessLinks::marketplaces($business) as $label => $url)<a href="{{ $url }}" target="_blank" rel="noopener noreferrer">{{ $label }} <span class="sr-only">{{ \App\Support\Locale::text('(öffnet in neuem Tab)') }}</span></a>@endforeach
            </div>@endif
            @foreach(\App\Support\BusinessLinks::socials($business) as $label => $url)<a href="{{ $url }}" target="_blank" rel="noopener noreferrer">{{ $label }} <span class="sr-only">{{ \App\Support\Locale::text('(öffnet in neuem Tab)') }}</span></a>@endforeach
        </div>
    </div>
    <div class="container-wide footer-bottom"><span>© {{ date('Y') }} MORANO+</span><div><a href="{{ route('imprint') }}">{{ \App\Support\Locale::text('Impressum') }}</a><a href="{{ route('privacy') }}">{{ \App\Support\Locale::text('Datenschutz') }}</a></div></div>
</footer>
