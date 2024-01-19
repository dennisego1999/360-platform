<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class ThreeSixtyGeneratorController extends Controller
{
    public function index() {
        return Inertia::render('Admin/ThreeSixtyGenerator/Index');
    }
}
