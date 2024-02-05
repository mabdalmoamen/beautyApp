<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;

class Lang
{
    public function handle($request, Closure $next)
    {
        if (request('lang')) {
            session()->put('language', request('lang'));
            $language = request('lang');
        } elseif (session('language')) {
            $language = session('language');
        } elseif (config('lang.primary_language')) {
            $language = config('lang.primary_language');
        } else {
            $language = "ar";
        }

        app()->setLocale($language);
        return $next($request);
    }
}
