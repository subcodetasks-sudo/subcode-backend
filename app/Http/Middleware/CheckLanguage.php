<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class CheckLanguage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = strtolower(trim((string) $request->header('Accept-Language', 'ar')));
        $locale = strtok($locale, ',;') ?: 'ar';

        if (in_array($locale, ['ar', 'en', 'tr'], true)) {
            App::setLocale($locale);
        }

        return $next($request);
    }
}
