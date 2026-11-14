<header class="site-header" data-site-header>
    <div class="nav-shell container-wide">
        <a class="brand" href="{{ route('home') }}" aria-label="MORANO+ – Startseite"><img src="{{ asset('images/logo/logo.png') }}" alt="MORANO+" width="174" height="58"></a>
        <button class="menu-toggle" type="button" aria-expanded="false" aria-controls="primary-nav" aria-label="Menü öffnen" data-menu-toggle><span></span><span></span><span></span></button>
        <nav class="primary-nav" id="primary-nav" aria-label="Hauptnavigation" data-primary-nav>
            <a href="{{ route('home') }}" @if(request()->routeIs('home')) aria-current="page" @endif>Startseite</a>
            <a href="{{ route('menu') }}" @if(request()->routeIs('menu')) aria-current="page" @endif>Speisekarte</a>
            <a href="{{ route('offers') }}" @if(request()->routeIs('offers')) aria-current="page" @endif>Angebote</a>
            <a href="{{ route('about') }}" @if(request()->routeIs('about')) aria-current="page" @endif>Über uns</a>
            <a href="{{ route('contact') }}" @if(request()->routeIs('contact')) aria-current="page" @endif>Kontakt</a>
        </nav>
        <a class="nav-cta" href="{{ route('contact') }}">Besuch planen <span aria-hidden="true">↗</span></a>
    </div>
</header>
