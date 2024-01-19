<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class EnsureLocaleIsPassed
{
    public function handle(Request $request, Closure $next)
    {
        // Ensure routes use the locale
        URL::defaults(['locale' => app()->getLocale()]);

        // Forget the parameter for route model binding
        $request->route()?->forgetParameter('locale');

        return $next($request);
    }
}
