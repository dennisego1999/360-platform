<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class FallbackController extends Controller
{
    public function __invoke(): Response
    {
        return Inertia::render('Errors/404');
    }
}
