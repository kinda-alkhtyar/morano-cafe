<header class="site-header" data-site-header>
    <div class="nav-shell container-wide">
        <a class="brand" href="{{ route('home') }}" aria-label="{{ \App\Support\Locale::text('MORANO+ – Startseite') }}"><img src="{{ asset('images/logo/logo.png') }}" alt="MORANO+" width="174" height="58"></a>
        <button class="menu-toggle" type="button" aria-expanded="false" aria-controls="primary-nav" aria-label="{{ \App\Support\Locale::fa() ? 'باز کردن منو' : 'Menü öffnen' }}" data-menu-toggle><span></span><span></span><span></span></button>
        <nav class="primary-nav" id="primary-nav" aria-label="{{ \App\Support\Locale::text('Hauptnavigation') }}" data-primary-nav>
            <a href="{{ route('home') }}" @if(request()->routeIs('home')) aria-current="page" @endif>{{ \App\Support\Locale::text('Startseite') }}</a>
            <a href="{{ route('menu') }}" @if(request()->routeIs('menu')) aria-current="page" @endif>{{ \App\Support\Locale::text('Speisekarte') }}</a>
            <a href="{{ route('offers') }}" @if(request()->routeIs('offers')) aria-current="page" @endif>{{ \App\Support\Locale::text('Angebote') }}</a>
            <a href="{{ route('about') }}" @if(request()->routeIs('about')) aria-current="page" @endif>{{ \App\Support\Locale::text('Über uns') }}</a>
            <a href="{{ route('contact') }}" @if(request()->routeIs('contact')) aria-current="page" @endif>{{ \App\Support\Locale::text('Kontakt') }}</a>
        </nav>
        <a class="nav-cta" href="{{ route('home') }}#standort">{{ \App\Support\Locale::text('Besuch planen') }}<span aria-hidden="true">↗</span></a>
        <div class="language-switch" aria-label="Language / زبان"><a href="{{ request()->fullUrlWithQuery(['lang' => 'de']) }}" lang="de" @if(!\App\Support\Locale::fa()) aria-current="true" @endif>Deutsch</a><span aria-hidden="true">|</span><a href="{{ request()->fullUrlWithQuery(['lang' => 'fa']) }}" lang="fa" dir="rtl" @if(\App\Support\Locale::fa()) aria-current="true" @endif>فارسی</a></div>
    </div>
</header>
