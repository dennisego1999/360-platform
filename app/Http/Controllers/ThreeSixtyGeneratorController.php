<?php

namespace App\Http\Controllers;

use App\Http\Resources\ThreeSixtyAreaResource;
use App\Http\Resources\ThreeSixtyClickpointCollection;
use App\Http\Resources\ThreeSixtyViewpointCollection;
use App\Models\Area;
use App\Models\Viewpoint;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ThreeSixtyGeneratorController extends Controller
{
    public function __invoke(Request $request, Area $area, ?Viewpoint $viewpoint = null)
    {
        if (! $viewpoint) {
            $viewpoint = $area->viewpoints->firstWhere('is_default', true);
        }

        return Inertia::render('ThreeSixtyArea', [
            'area' => new ThreeSixtyAreaResource($area),
            'viewpoints' => new ThreeSixtyViewpointCollection($area->viewpoints, true, false),
            'startingViewpointId' => $viewpoint->id,
            'startingClickpoints' => new ThreeSixtyClickpointCollection($viewpoint->clickpoints, false),
        ]);
    }
}
