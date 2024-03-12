<?php

namespace App\Http\Controllers;

use App\Http\Resources\ThreeSixtyAreaCollection;
use App\Models\Area;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function __invoke(Request $request)
    {
        $areas = Area::all();

        return Inertia::render('Home', [
            'areas' => new ThreeSixtyAreaCollection($areas),
        ]);
    }
}
