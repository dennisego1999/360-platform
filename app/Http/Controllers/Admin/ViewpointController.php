<?php

namespace App\Http\Controllers\Admin;

use App\Actions\ViewpointCreateAction;
use App\Actions\ViewpointDestroyAction;
use App\Actions\ViewpointUpdateAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\ThreeSixtyViewpointRequest;
use App\Http\Resources\ThreeSixtyAreaResource;
use App\Http\Resources\ThreeSixtyViewpointResource;
use App\Models\Area;
use App\Models\Viewpoint;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ViewpointController extends Controller
{
    public function index(Area $area): Response
    {
        $viewpoints = Viewpoint::query()
            ->where('area_id', $area->id)
            ->get();

        return Inertia::render('Admin/ThreeSixtyGenerator/Viewpoints/Index', [
            'area' => $area,
            'viewpoints' => $viewpoints,
        ]);
    }

    public function create(Area $area): Response
    {
        return Inertia::render('Admin/ThreeSixtyGenerator/Viewpoints/Create', [
            'area' => $area,
        ]);
    }

    public function store(
        ThreeSixtyViewpointRequest $request,
        ViewpointCreateAction $viewpointCreateAction,
        Area $area
    ): RedirectResponse {
        // Authorize
        $this->authorize('create', Viewpoint::class);

        // Validate input
        $validated = $request->validated();

        // Handle action
        $viewpointCreateAction->handle($validated, $area);

        // Return
        return redirect()
            ->route('admin.three-sixty-generator.viewpoint.index', [
                'area' => $area,
            ])
            ->with('success', trans('spa.toasts.description.three_sixty_viewpoint_created'));
    }

    public function show(Area $area, Viewpoint $viewpoint): Response
    {
        return Inertia::render('Admin/ThreeSixtyGenerator/Viewpoints/Show', [
            'area' => new ThreeSixtyAreaResource($area, true),
            'viewpoint' => new ThreeSixtyViewpointResource($viewpoint),
        ]);
    }

    public function edit(Area $area, Viewpoint $viewpoint): Response
    {
        return Inertia::render('Admin/ThreeSixtyGenerator/Viewpoints/Edit', [
            'area' => new ThreeSixtyAreaResource($area, true),
            'viewpoint' => new ThreeSixtyViewpointResource($viewpoint),
        ]);
    }

    public function update(
        ThreeSixtyViewpointRequest $request,
        ViewpointUpdateAction $viewpointUpdateAction,
        Area $area,
        Viewpoint $viewpoint,
    ): RedirectResponse {
        // Authorize
        $this->authorize('update', $viewpoint);

        // Validate input
        $validated = $request->validated();

        // Handle action
        $viewpointUpdateAction->handle($validated, $viewpoint);

        // Return
        return redirect()
            ->route('admin.three-sixty-generator.viewpoint.index', [
                'area' => $area,
            ])
            ->with('success', trans('spa.toasts.description.three_sixty_viewpoint_updated'));
    }

    public function destroy(
        ViewpointDestroyAction $viewpointDestroyAction,
        Area $area,
        Viewpoint $viewpoint,
    ): RedirectResponse {
        // Authorize
        $this->authorize('delete', $viewpoint);

        // Handle action
        $viewpointDestroyAction->handle($viewpoint);

        // Return
        return redirect()
            ->route('admin.three-sixty-generator.viewpoint.index', [
                'area' => $area,
            ])
            ->with('success', trans('spa.toasts.description.three_sixty_viewpoint_deleted'));
    }
}
