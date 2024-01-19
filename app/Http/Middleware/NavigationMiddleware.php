<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;

class NavigationMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // If the user is authenticated, update navigation items for dashboard pages
        if (Auth::check() && ($request->routeIs('admin.*') || $request->routeIs('profile.show'))) {
            Inertia::share('navigationItems', static fn () => static::getDashboardItems($request));
            return $next($request);
        }

        Inertia::share('navigationItems', static fn () => static::getMainItems($request));

        return $next($request);
    }

    public static function getMainItems(Request $request)
    {
        // Get the user
        $user = $request->user();

        $items = collect([
            'login' => [
                'href' => route('login'),
                'current' => $request->routeIs('login'),
                'label' => trans('spa.pages.users.login'),
                'active' => !$user,
                'method' => 'get',
            ],
            'register' => [
                'href' => route('register'),
                'current' => $request->routeIs('register'),
                'label' => trans('spa.pages.users.register'),
                'active' => !$user,
                'method' => 'get',
            ],
            'dashboard' => [
                'href' => route('admin.dashboard'),
                'current' => $request->routeIs('admin.dashboard'),
                'label' => trans('spa.pages.dashboard.label'),
                'active' => !!$user && $user->can('access-dashboard'),
                'method' => 'get',
            ],
            'profile' => [
                'href' => route('profile.show'),
                'current' => $request->routeIs('profile.show'),
                'label' => trans('spa.pages.users.profile'),
                'active' => !!$user,
                'method' => 'get',
            ],
            'logout' => [
                'href' => route('logout'),
                'current' => $request->routeIs('logout'),
                'label' => trans('spa.pages.users.logout'),
                'active' => !!$user,
                'method' => 'post',
            ],
        ]);

        return $items->filter(fn ($item) => $item['active']);
    }

    public static function getDashboardItems(Request $request)
    {
        // Get the user
        $user = $request->user();

        $items = collect([
            'dashboard' => [
                'href' => route('admin.dashboard'),
                'current' => $request->routeIs('admin.dashboard'),
                'label' => trans('spa.pages.dashboard.label'),
                'active' => $user->can('access-dashboard'),
            ],
            'users' => [
                'href' => route('admin.users.index'),
                'current' => $request->routeIs('admin.users.*'),
                'label' => trans('spa.pages.users.label'),
                'active' => $user->can('manage-users'),
            ],
            'translations' => [
                'href' => route('admin.translations.index'),
                'current' => $request->routeIs('admin.translations.*'),
                'label' => trans('spa.pages.translations.label'),
                'active' => $user->can('manage-translations'),
            ],
        ]);

        return $items->filter(fn ($item) => $item['active']);
    }
}
