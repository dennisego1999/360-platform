<?php

namespace App\Http\Controllers;

use App\Actions\ThreeSixtyAreaCreateAction;
use App\Actions\ThreeSixtyAreaDestroyAction;
use App\Actions\ThreeSixtyAreaUpdateAction;
use App\Http\Requests\ThreeSixtyAreaRequest;
use App\Http\Resources\ThreeSixtyAreaResource;
use App\Models\ThreeSixtyArea;
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

    public function create()
    {
        return Inertia::render('Admin/ThreeSixtyGenerator/Area/Create');
    }

    public function store(ThreeSixtyAreaRequest $request, ThreeSixtyAreaCreateAction $threeSixtyAreaCreateAction)
    {
        // Authorize
        $this->authorize('create', ThreeSixtyArea::class);

        // Validate input
        $validated = $request->validated();

        // Handle action
        $threeSixtyAreaCreateAction->handle($validated);

        // Return
        return redirect()
            ->route('admin.three-sixty-generator.three-sixty-area.index')
            ->with('success', trans('spa.toasts.description.three_sixty_area_created'));
    }

    public function show(ThreeSixtyArea $threeSixtyArea)
    {
        return Inertia::render('Admin/ThreeSixtyGenerator/Area/Show', [
            'area' => new ThreeSixtyAreaResource($threeSixtyArea)
        ]);
    }

    public function edit(ThreeSixtyArea $threeSixtyArea)
    {
        return Inertia::render('Admin/ThreeSixtyGenerator/Area/Edit', [
            'area' => new ThreeSixtyAreaResource($threeSixtyArea)
        ]);
    }

    public function update(
        ThreeSixtyAreaRequest $request,
        ThreeSixtyAreaUpdateAction $threeSixtyAreaUpdateAction,
        ThreeSixtyArea $threeSixtyArea
    ) {
        // Authorize
        $this->authorize('update', $threeSixtyArea);

        // Validate input
        $validated = $request->validated();

        // Handle action
        $threeSixtyAreaUpdateAction->handle($validated, $threeSixtyArea);

        // Return
        return redirect()
            ->route('admin.three-sixty-generator.three-sixty-area.index')
            ->with('success', trans('spa.toasts.description.three_sixty_area_updated'));
    }

    public function destroy(ThreeSixtyAreaDestroyAction $threeSixtyAreaDestroyAction, ThreeSixtyArea $threeSixtyArea)
    {
        // Authorize
        $this->authorize('delete', $threeSixtyArea);

        // Handle action
        $threeSixtyAreaDestroyAction->handle($threeSixtyArea);

        // Return
        return redirect()
            ->route('admin.three-sixty-generator.three-sixty-area.index')
            ->with('success', trans('spa.toasts.description.three_sixty_area_deleted'));
    }
}
