<!doctype html>
<html lang="{{ \App\Support\Locale::fa() ? 'fa-IR' : 'de-AT' }}" dir="{{ \App\Support\Locale::fa() ? 'rtl' : 'ltr' }}">
<head>
    @php
        $pageMeta = match (request()->route()?->getName()) {
            'menu' => ['Speisekarte', 'Pinsa, Salate, Sandwiches, Kuchen und Getränke bei MORANO+ in Wien.'],
            'offers' => ['Aktuelle Angebote', 'Aktuelle Angebote von MORANO+ in Wien.'],
            'about' => ['Über uns', 'Erfahre mehr über MORANO+ in Wien.'],
            'contact' => ['Kontakt & Besuch', 'Adresse und Kontakt von MORANO+ in Wien.'],
            'imprint' => ['Impressum', 'Impressum von MORANO+ in Wien.'],
            'privacy' => ['Datenschutz', 'Datenschutzhinweise von MORANO+ in Wien.'],
            default => ['MORANO+ · Café und Restaurant in Wien', 'MORANO+ in Wien: Kaffee, Kuchen und kleine Speisen.'],
        };
    @endphp
    @if(\App\Support\Locale::fa())
        @php $pageMeta = match (request()->route()?->getName()) {
            'menu' => ['منو', 'منوی پینسا، سالاد، ساندویچ، کیک و نوشیدنی در MORANO+ وین.'],
            'offers' => ['پیشنهادهای روز', 'پیشنهادهای ویژهٔ MORANO+ در وین.'],
            'about' => ['دربارهٔ ما', 'با کافه و رستوران MORANO+ در وین آشنا شوید.'],
            'contact' => ['تماس و بازدید', 'نشانی و راه‌های تماس با MORANO+ در وین.'],
            'imprint' => ['مشخصات حقوقی', 'مشخصات حقوقی MORANO+ در وین.'],
            'privacy' => ['حریم خصوصی', 'اطلاعات حریم خصوصی MORANO+ در وین.'],
            default => ['MORANO+ · کافه و رستوران در وین', 'قهوه، کیک و غذاهای سبک در MORANO+ وین.'],
        }; @endphp
    @endif
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#092d1d">
    <meta name="description" content="{{ $pageMeta[1] }}">
    <link rel="canonical" href="{{ url()->current() }}">
    @if(request()->routeIs('imprint', 'privacy') && blank(\App\Models\HomepageContent::find(1)?->{request()->routeIs('imprint') ? 'imprint_content' : 'privacy_content'}))<meta name="robots" content="noindex,follow">@endif
    <meta property="og:type" content="website">
    <meta property="og:locale" content="{{ \App\Support\Locale::fa() ? 'fa_IR' : 'de_AT' }}">
    <meta property="og:title" content="{{ $pageMeta[0] }} · MORANO+">
    <meta property="og:description" content="{{ $pageMeta[1] }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ asset('images/hero/hero.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,500;0,600;1,400;1,500&family=Vazirmatn:wght@400;500;600;700&display=swap" rel="stylesheet">
    <title>{{ $pageMeta[0] }}{{ request()->routeIs('home') ? '' : ' · MORANO+' }}</title>
    @if (request()->routeIs('home'))
        <link rel="preload" as="image" href="{{ asset('images/hero/hero.webp') }}" fetchpriority="high">
    @endif
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="{{ request()->routeIs('home') ? 'is-home' : 'is-inner' }}" data-locale="{{ app()->getLocale() }}">
    <a class="skip-link" href="#main">{{ \App\Support\Locale::text('Zum Inhalt springen') }}</a>
    <x-site-nav />
    <main id="main">@yield('content')</main>
    <x-site-footer />
</body>
</html>
