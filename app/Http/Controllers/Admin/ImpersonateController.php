<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Inertia\Inertia;

class ImpersonateController extends Controller
{
    public function __invoke(User $user)
    {
        if (auth()->check()) {
            //Impersonate user
            auth()->user()->impersonate($user);
        }

        //Redirect back with hard page reload
        return Inertia::location(route('admin.dashboard'));
    }
}
