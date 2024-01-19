<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyAdminAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        // Get the user
        $user = $request->user();

        // Redirect when user is not allowed in admin dashboard
        if(!$user->can('access-dashboard')) {
            return redirect(route('home'));
        }

        return $next($request);
    }
}
