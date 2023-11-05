<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\App;

class Language
{
    public function handle(Request $request, Closure $next): Response
    {
        $localization = $request->header('Accept-Language');
        $localization = array_key_exists($localization, config('languages')) ? $localization : 'en';
        App::setLocale($localization);

        return $next($request);
    }
}
