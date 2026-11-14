<!doctype html>
<html lang="de-AT">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#092d1d">
    <meta name="description" content="MORANO+ – Café und Restaurant in Wien. Kaffee, Kuchen und kleine Speisen.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,500;0,600;1,400;1,500&display=swap" rel="stylesheet">
    <title>{{ isset($title) ? $title . ' · MORANO+' : 'MORANO+ · Café und Restaurant in Wien' }}</title>
    @if (request()->routeIs('home'))
        <link rel="preload" as="image" href="{{ asset('images/hero/hero.png') }}" fetchpriority="high">
    @endif
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="{{ request()->routeIs('home') ? 'is-home' : 'is-inner' }}">
    <a class="skip-link" href="#main">Zum Inhalt springen</a>
    <x-site-nav />
    <main id="main">@yield('content')</main>
    <x-site-footer />
</body>
</html>
