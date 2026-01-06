<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function changeLanguage(string $locale)
    {
        $availableLocales = array_keys(config('app.available_locales', []));

        if (in_array($locale, $availableLocales)) {
            Session::put('locale', $locale);
        }

        return redirect()->back();
    }
}