<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Clickpoint;
use App\Models\Viewpoint;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ClickpointController extends Controller
{
    public function index(Area $area, Viewpoint $viewpoint)
    {
        $clickpoints = Clickpoint::query()
            ->where('viewpoint_id', $viewpoint->id)
            ->get();

        return Inertia::render('Admin/ThreeSixtyGenerator/Clickpoints/Index', [
            'area' => $area,
            'viewpoint' => $viewpoint,
            'clickpoints' => $clickpoints
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Clickpoint $clickpoint)
    {
        //
    }

    public function edit(Clickpoint $clickpoint)
    {
        //
    }

    public function update(Request $request, Clickpoint $clickpoint)
    {
        //
    }

    public function destroy(Clickpoint $clickpoint)
    {
        //
    }
}
