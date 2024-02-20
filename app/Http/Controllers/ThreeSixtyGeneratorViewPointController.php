<?php

namespace App\Http\Controllers;

use App\Actions\ThreeSixtyViewPointCreateAction;
use App\Actions\ThreeSixtyViewPointDestroyAction;
use App\Actions\ThreeSixtyViewPointUpdateAction;
use App\Http\Requests\ThreeSixtyViewPointRequest;
use App\Http\Resources\ThreeSixtyAreaResource;
use App\Http\Resources\ThreeSixtyViewpointResource;
use App\Models\ThreeSixtyArea;
use App\Models\ThreeSixtyViewPoint;
use App\Models\ViewPoint;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ThreeSixtyGeneratorViewPointController extends Controller
{
    public function index(ThreeSixtyArea $area): Response
    {
        $viewpoints = ThreeSixtyViewPoint::query()
            ->where('three_sixty_area_id', $area->id)
            ->get();

        return Inertia::render('Admin/ThreeSixtyGenerator/ViewPoints/Index', [
            'area' => $area,
            'viewpoints' => $viewpoints
        ]);
    }

    public function create(ThreeSixtyArea $area): Response
    {
        return Inertia::render('Admin/ThreeSixtyGenerator/ViewPoints/Create', [
            'area' => $area,
        ]);
    }

    public function store(
        ThreeSixtyViewPointRequest $request,
        ThreeSixtyViewPointCreateAction $threeSixtyViewPointCreateAction,
        ThreeSixtyArea $area
    ): RedirectResponse {
        // Authorize
        $this->authorize('create', ThreeSixtyViewPoint::class);

        // Validate input
        $validated = $request->validated();

        // Handle action
        $threeSixtyViewPointCreateAction->handle($validated, $area);

        // Return
        return redirect()
            ->route('admin.three-sixty-generator.view-point.index', [
                'area' => $area
            ])
            ->with('success', trans('spa.toasts.description.three_sixty_view_point_created'));
    }

    public function show(ThreeSixtyArea $area, ThreeSixtyViewPoint $viewPoint): Response
    {
        ray($viewPoint);
        return Inertia::render('Admin/ThreeSixtyGenerator/ViewPoints/Show', [
            'area' => new ThreeSixtyAreaResource($area),
            'viewPoint' => new ThreeSixtyViewPointResource($viewPoint)
        ]);
    }

    public function edit(ThreeSixtyArea $area, ThreeSixtyViewPoint $viewPoint): Response
    {
        return Inertia::render('Admin/ThreeSixtyGenerator/ViewPoints/Edit', [
            'area' => new ThreeSixtyAreaResource($area),
            'viewPoint' => new ThreeSixtyViewPointResource($viewPoint)
        ]);
    }

    public function update(
        ThreeSixtyViewPointRequest $request,
        ThreeSixtyViewPointUpdateAction $threeSixtyViewPointUpdateAction,
        ThreeSixtyArea $area,
        ThreeSixtyViewPoint $viewPoint,
    ): RedirectResponse {
        $this->authorize('update', $viewPoint);

        // Validate input
        $validated = $request->validated();

        // Handle action
        $threeSixtyViewPointUpdateAction->handle($validated, $viewPoint);

        // Return
        return redirect()
            ->route('admin.three-sixty-generator.view-point.index', [
                'area' => $area,
            ])
            ->with('success', trans('spa.toasts.description.three_sixty_view_point_updated'));
    }

    public function destroy(
        ThreeSixtyViewPointDestroyAction $threeSixtyViewPointDestroyAction,
        ThreeSixtyArea $area,
        ThreeSixtyViewPoint $viewPoint,
    ): RedirectResponse {
        // Authorize
        $this->authorize('delete', $viewPoint);

        // Handle action
        $threeSixtyViewPointDestroyAction->handle($viewPoint);

        // Return
        return redirect()
            ->route('admin.three-sixty-generator.view-point.index', [
                'area' => $area,
            ])
            ->with('success', trans('spa.toasts.description.three_sixty_view_point_deleted'));
    }
}
