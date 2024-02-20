<?php

namespace App\Http\Controllers;

use App\Actions\ThreeSixtyAreaCreateAction;
use App\Actions\ThreeSixtyAreaDestroyAction;
use App\Actions\ThreeSixtyAreaUpdateAction;
use App\Http\Requests\ThreeSixtyAreaRequest;
use App\Http\Resources\ThreeSixtyAreaResource;
use App\Models\ThreeSixtyArea;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ThreeSixtyGeneratorAreaController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin/ThreeSixtyGenerator/Area/Index', [
            'threeSixtyAreas' => ThreeSixtyArea::all(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/ThreeSixtyGenerator/Area/Create');
    }

    public function store(
        ThreeSixtyAreaRequest $request,
        ThreeSixtyAreaCreateAction $threeSixtyAreaCreateAction
    ): RedirectResponse {
        // Authorize
        $this->authorize('create', ThreeSixtyArea::class);

        // Validate input
        $validated = $request->validated();

        // Handle action
        $threeSixtyAreaCreateAction->handle($validated);

        // Return
        return redirect()
            ->route('admin.three-sixty-generator.area.index')
            ->with('success', trans('spa.toasts.description.three_sixty_area_created'));
    }

    public function show(ThreeSixtyArea $area): Response
    {
        return Inertia::render('Admin/ThreeSixtyGenerator/Area/Show', [
            'area' => new ThreeSixtyAreaResource($area)
        ]);
    }

    public function edit(ThreeSixtyArea $area): Response
    {
        return Inertia::render('Admin/ThreeSixtyGenerator/Area/Edit', [
            'area' => new ThreeSixtyAreaResource($area)
        ]);
    }

    public function update(
        ThreeSixtyAreaRequest $request,
        ThreeSixtyAreaUpdateAction $threeSixtyAreaUpdateAction,
        ThreeSixtyArea $area
    ): RedirectResponse {
        // Authorize
        $this->authorize('update', $area);

        // Validate input
        $validated = $request->validated();

        // Handle action
        $threeSixtyAreaUpdateAction->handle($validated, $area);

        // Return
        return redirect()
            ->route('admin.three-sixty-generator.area.index')
            ->with('success', trans('spa.toasts.description.three_sixty_area_updated'));
    }

    public function destroy(
        ThreeSixtyAreaDestroyAction $threeSixtyAreaDestroyAction,
        ThreeSixtyArea $area
    ): RedirectResponse {
        // Authorize
        $this->authorize('delete', $area);

        // Handle action
        $threeSixtyAreaDestroyAction->handle($area);

        // Return
        return redirect()
            ->route('admin.three-sixty-generator.area.index')
            ->with('success', trans('spa.toasts.description.three_sixty_area_deleted'));
    }
}
