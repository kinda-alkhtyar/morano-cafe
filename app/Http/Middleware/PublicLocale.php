<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PublicLocale
{
    public function handle(Request $request, Closure $next)
    {
        $locale = $request->query('lang');
        if (in_array($locale, ['de', 'fa'], true)) {
            $request->session()->put('public_locale', $locale);
        }
        app()->setLocale($request->session()->get('public_locale', 'de'));
        return $next($request);
    }
}
