<footer class="site-footer">
    <div class="container-wide footer-main">
        <div><a class="footer-brand" href="{{ route('home') }}"><img src="{{ asset('images/logo/logo.png') }}" alt="MORANO+" width="210" height="70"></a><p>Kaffee, kleine Speisen und Zeit zum Zusammensitzen. MORANO+ in Wien.</p></div>
        <nav aria-label="Footernavigation"><span class="footer-label">MORANO+</span><a href="{{ route('menu') }}">Speisekarte</a><a href="{{ route('offers') }}">Angebote</a><a href="{{ route('about') }}">Über uns</a><a href="{{ route('contact') }}">Kontakt</a></nav>
        <div class="footer-note"><span class="footer-label">MORANO+ Wien</span><p>Wir freuen uns auf deinen Besuch.</p><a href="{{ route('contact') }}">Kontakt <span aria-hidden="true">↗</span></a></div>
    </div>
    <div class="container-wide footer-bottom"><span>© {{ date('Y') }} MORANO+</span><div><a href="{{ route('imprint') }}">Impressum</a><a href="{{ route('privacy') }}">Datenschutz</a></div></div>
</footer>
