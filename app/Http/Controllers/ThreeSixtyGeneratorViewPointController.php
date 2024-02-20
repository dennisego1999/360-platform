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
    public function index(ThreeSixtyArea $threeSixtyArea): Response
    {
        $viewpoints = ThreeSixtyViewPoint::query()
            ->where('three_sixty_area_id', $threeSixtyArea->id)
            ->get();

        return Inertia::render('Admin/ThreeSixtyGenerator/ViewPoints/Index', [
            'area' => $threeSixtyArea,
            'viewpoints' => $viewpoints
        ]);
    }

    public function create(ThreeSixtyArea $threeSixtyArea): Response
    {
        return Inertia::render('Admin/ThreeSixtyGenerator/ViewPoints/Create', [
            'area' => $threeSixtyArea,
        ]);
    }

    public function store(
        ThreeSixtyViewPointRequest $request,
        ThreeSixtyViewPointCreateAction $threeSixtyViewPointCreateAction,
        ThreeSixtyArea $threeSixtyArea
    ): RedirectResponse {
        // Authorize
        $this->authorize('create', ThreeSixtyViewPoint::class);

        // Validate input
        $validated = $request->validated();

        // Handle action
        $threeSixtyViewPointCreateAction->handle($validated, $threeSixtyArea);

        // Return
        return redirect()
            ->route('admin.three-sixty-generator.three-sixty-view-point.index', [
                'threeSixtyArea' => $threeSixtyArea
            ])
            ->with('success', trans('spa.toasts.description.three_sixty_view_point_created'));
    }

    public function show(ThreeSixtyArea $threeSixtyArea, ThreeSixtyViewPoint $threeSixtyViewPoint): Response
    {
        return Inertia::render('Admin/ThreeSixtyGenerator/ViewPoints/Show', [
            'area' => new ThreeSixtyAreaResource($threeSixtyArea),
            'viewPoint' => new ThreeSixtyViewPointResource($threeSixtyViewPoint)
        ]);
    }

    public function edit(ThreeSixtyArea $threeSixtyArea, ThreeSixtyViewPoint $threeSixtyViewPoint): Response
    {
        return Inertia::render('Admin/ThreeSixtyGenerator/ViewPoints/Edit', [
            'area' => new ThreeSixtyAreaResource($threeSixtyArea),
            'viewPoint' => new ThreeSixtyViewPointResource($threeSixtyViewPoint)
        ]);
    }

    public function update(
        ThreeSixtyViewPointRequest $request,
        ThreeSixtyViewPointUpdateAction $threeSixtyViewPointUpdateAction,
        ThreeSixtyArea $threeSixtyArea,
        ThreeSixtyViewPoint $threeSixtyViewPoint,
    ): RedirectResponse {
        $this->authorize('update', $threeSixtyViewPoint);

        // Validate input
        $validated = $request->validated();

        // Handle action
        $threeSixtyViewPointUpdateAction->handle($validated, $threeSixtyViewPoint);

        // Return
        return redirect()
            ->route('admin.three-sixty-generator.three-sixty-view-point.index', [
                'threeSixtyArea' => $threeSixtyArea,
            ])
            ->with('success', trans('spa.toasts.description.three_sixty_view_point_updated'));
    }

    public function destroy(
        ThreeSixtyViewPointDestroyAction $threeSixtyViewPointDestroyAction,
        ThreeSixtyArea $threeSixtyArea,
        ThreeSixtyViewPoint $threeSixtyViewPoint,
    ): RedirectResponse {
        // Authorize
        $this->authorize('delete', $threeSixtyViewPoint);

        // Handle action
        $threeSixtyViewPointDestroyAction->handle($threeSixtyViewPoint);

        // Return
        return redirect()
            ->route('admin.three-sixty-generator.three-sixty-view-point.index', [
                'threeSixtyArea' => $threeSixtyArea,
            ])
            ->with('success', trans('spa.toasts.description.three_sixty_view_point_deleted'));
    }
}
