@extends('layouts.app')
@section('content')
<div class="menu-page" data-menu-page>
    <header class="menu-intro container-wide" data-reveal>
        <p class="eyebrow">{{ \App\Support\Locale::text('MORANO+ · Wien') }}</p>
        <h1>{{ \App\Support\Locale::text('Unsere Speisekarte') }}</h1>
        <p>{{ \App\Support\Locale::text('Pinsa, Salate, Sandwiches, Kuchen und Getränke – entdecke unsere Auswahl.') }}</p>
        <p>{{ \App\Support\Locale::text('Die angezeigten Referenzpreise stammen von Lieferplattformen. Endgültige Restaurantpreise müssen noch bestätigt werden.') }}</p>
    </header>
    <div class="menu-tools container-wide">
        <nav class="menu-filters" aria-label="{{ \App\Support\Locale::text('Speisekarten-Kategorien') }}" data-menu-filters>
            <a href="{{ route('menu') }}" data-filter="all" aria-current="true">{{ \App\Support\Locale::text('Alles') }}</a>
            @foreach($categories as $category)<a href="{{ route('menu', ['kategorie' => $category->slug]) }}" data-filter="{{ $category->slug }}">{{ \App\Support\Locale::text($category->name) }}</a>@endforeach
        </nav>
        <nav class="menu-subfilters" aria-label="{{ \App\Support\Locale::text('Getränkearten') }}" data-menu-subfilters>
            @foreach(\App\Support\MenuGroups::DRINKS as $key => $label)<a href="{{ route('menu', ['gruppe' => $key]) }}" data-filter-sub="{{ $key }}">{{ \App\Support\Locale::text($label) }}</a>@endforeach
        </nav>
        <label class="menu-search"><span>{{ \App\Support\Locale::text('Speisekarte durchsuchen') }}</span><input type="search" data-menu-search placeholder="{{ \App\Support\Locale::fa() ? 'جست‌وجوی محصول…' : 'Produkt suchen …' }}" autocomplete="off"></label>
    </div>
    <div class="container-wide menu-results" aria-live="polite"><p data-menu-count></p><p data-menu-empty hidden>{{ \App\Support\Locale::text('Zu dieser Suche gibt es derzeit keine Einträge.') }}</p></div>
    @forelse($categories as $category)
        <section class="menu-category container-wide" id="kategorie-{{ $category->slug }}" data-category="{{ $category->slug }}" aria-labelledby="titel-{{ $category->slug }}">
            <div class="menu-category-heading" data-reveal><p class="eyebrow">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }} / {{ \App\Support\Locale::text('Speisekarte') }}</p><h2 id="titel-{{ $category->slug }}">{{ \App\Support\Locale::text($category->name) }}</h2></div>
            @foreach(\App\Support\MenuGroups::for($category) as $group)
            <div class="menu-group" data-menu-group="{{ $group['key'] }}">
                @if($group['label'])<h3 class="menu-group-title">{{ \App\Support\Locale::text($group['label']) }}</h3>@endif
                <div class="menu-grid">
                @foreach($group['products'] as $product)
                    <article class="menu-product" data-menu-product data-search="{{ mb_strtolower(\App\Support\Locale::product($product, 'name').' '.(\App\Support\Locale::product($product, 'description') ?? '').' '.(\App\Support\Locale::product($product, 'ingredients') ?? '')) }}" data-reveal>
                        <div class="menu-product-image">
                            @if(\App\Support\ImageUrl::exists($product->image_path))<img src="{{ \App\Support\ImageUrl::for($product->image_path) }}" alt="{{ \App\Support\Locale::product($product, 'name') }}" loading="lazy" decoding="async" width="1200" height="1200">
                            @else<span class="brand-placeholder" aria-label="{{ \App\Support\Locale::text('Bild wird ergänzt') }}"><span>MORANO<span class="brand-plus">+</span></span></span>@endif
                        </div>
                        <div class="menu-product-body"><h4>{{ \App\Support\Locale::product($product, 'name') }}</h4>@if(\App\Support\Locale::product($product, 'description'))<p>{{ \App\Support\Locale::product($product, 'description') }}</p>@endif
                            <div class="menu-product-foot">@if($product->price !== null || $product->reference_price !== null)<span class="menu-price"><bdi>{{ number_format(($product->price ?? $product->reference_price) / 100, 2, ',', '.') }} €</bdi>@if($product->price === null)<small>{{ \App\Support\Locale::text('Referenzpreis') }}</small>@endif</span>@endif<button type="button" data-product-open="{{ $product->id }}" aria-haspopup="dialog">{{ \App\Support\Locale::text('Details') }}<span aria-hidden="true">↗</span></button></div>
                        </div>
                    </article>
                @endforeach
                </div>
            </div>
            @endforeach
        </section>
    @empty
        <p class="container-wide">{{ \App\Support\Locale::text('Unsere Speisekarte ist derzeit noch nicht online verfügbar.') }}</p>
    @endforelse
    @foreach($categories as $category)
        @foreach($category->products as $product)
            <dialog class="menu-dialog" data-product-dialog="{{ $product->id }}" aria-labelledby="dialog-title-{{ $product->id }}">
                <button type="button" class="menu-dialog-close" data-product-close aria-label="{{ \App\Support\Locale::text('Details schließen') }}">×</button>
                <div class="menu-dialog-grid"><div class="menu-dialog-image">@if(\App\Support\ImageUrl::exists($product->image_path))<img src="{{ \App\Support\ImageUrl::for($product->image_path) }}" alt="{{ \App\Support\Locale::product($product, 'name') }}" loading="lazy" decoding="async" width="1200" height="1200">@else<span class="brand-placeholder" aria-label="{{ \App\Support\Locale::text('Bild wird ergänzt') }}"><span>MORANO<span class="brand-plus">+</span></span></span>@endif</div>
                <div class="menu-dialog-copy"><p class="eyebrow">{{ \App\Support\Locale::text($category->name) }}</p><h2 id="dialog-title-{{ $product->id }}">{{ \App\Support\Locale::product($product, 'name') }}</h2>@if(\App\Support\Locale::product($product, 'description'))<p>{{ \App\Support\Locale::product($product, 'description') }}</p>@endif
                    @if(\App\Support\Locale::product($product, 'ingredients'))<h3>{{ \App\Support\Locale::text('Zutaten') }}</h3><p>{{ \App\Support\Locale::product($product, 'ingredients') }}</p>@endif
                    @if($product->allergens->isNotEmpty())<h3>{{ \App\Support\Locale::text('Allergene') }}</h3><p>{{ $product->allergens->pluck('name')->join(', ') }}</p>@endif
                    @if($product->price !== null || $product->reference_price !== null)<p class="menu-dialog-price"><bdi>{{ number_format(($product->price ?? $product->reference_price) / 100, 2, ',', '.') }} €</bdi>@if($product->price === null)<small>{{ \App\Support\Locale::text('Referenzpreis · Restaurantpreis noch zu bestätigen') }}</small>@endif</p>@endif
                </div></div>
            </dialog>
        @endforeach
    @endforeach
</div>
@endsection
