<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $availableLocales = array_values(Config::get('app.available_locales', []));
        $defaultLocale = Config::get('app.locale', 'en');

        if (Session::has('locale') && in_array(Session::get('locale'), $availableLocales)) {
            App::setLocale(Session::get('locale'));
        } else {
            App::setLocale($defaultLocale);
        }

        return $next($request);
    }
}