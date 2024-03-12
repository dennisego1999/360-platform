<?php

namespace App\Http\Controllers;

use App\Http\Resources\ThreeSixtyAreaResource;
use App\Http\Resources\ThreeSixtyClickpointResource;
use App\Http\Resources\ThreeSixtyViewpointResource;
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
            'startingViewpoint' => new ThreeSixtyViewpointResource($viewpoint),
            'startingClickpoints' => ThreeSixtyClickpointResource::collection($viewpoint->clickpoints),
        ]);
    }
}
