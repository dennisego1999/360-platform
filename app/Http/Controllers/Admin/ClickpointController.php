<?php

namespace App\Http\Controllers\Admin;

use App\Actions\ClickpointCreateAction;
use App\Actions\ClickpointDestroyAction;
use App\Actions\ClickpointUpdateAction;
use App\Enums\ContentTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\ThreeSixtyClickpointRequest;
use App\Http\Resources\ThreeSixtyAreaResource;
use App\Http\Resources\ThreeSixtyClickpointResource;
use App\Http\Resources\ThreeSixtyViewpointCollection;
use App\Http\Resources\ThreeSixtyViewpointResource;
use App\Models\Area;
use App\Models\Clickpoint;
use App\Models\Viewpoint;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ClickpointController extends Controller
{
    public function index(Area $area, Viewpoint $viewpoint): Response
    {
        $clickpoints = Clickpoint::query()
            ->where('viewpoint_id', $viewpoint->id)
            ->get();

        return Inertia::render('Admin/ThreeSixtyGenerator/Clickpoints/Index', [
            'area' => $area,
            'viewpoint' => $viewpoint,
            'clickpoints' => $clickpoints,
        ]);
    }

    public function create(Area $area, Viewpoint $viewpoint): Response
    {
        return Inertia::render('Admin/ThreeSixtyGenerator/Clickpoints/Create', [
            'area' => new ThreeSixtyAreaResource($area, true),
            'viewpoint' => new ThreeSixtyViewpointResource($viewpoint),
            'contentTypes' => ContentTypeEnum::toValues(),
            'viewpoints' => new ThreeSixtyViewpointCollection($area->viewpoints),
        ]);
    }

    public function store(
        ThreeSixtyClickpointRequest $request,
        ClickpointCreateAction $clickpointCreateAction,
        Area $area,
        Viewpoint $viewpoint,
    ): RedirectResponse {
        // Authorize
        $this->authorize('create', Clickpoint::class);

        // Validate input
        $validated = $request->validated();

        // Handle action
        $clickpointCreateAction->handle($validated, $viewpoint);

        // Return
        return redirect()
            ->route('admin.three-sixty-generator.clickpoint.index', [
                'area' => $area,
                'viewpoint' => $viewpoint,
            ])
            ->with('success', trans('spa.toasts.description.three_sixty_clickpoint_created'));
    }

    public function show(Area $area, Viewpoint $viewpoint, Clickpoint $clickpoint): Response
    {
        return Inertia::render('Admin/ThreeSixtyGenerator/Clickpoints/Show', [
            'area' => new ThreeSixtyAreaResource($area, true),
            'viewpoint' => new ThreeSixtyViewpointResource($viewpoint),
            'clickpoint' => new ThreeSixtyClickpointResource($clickpoint, true),
            'contentTypes' => ContentTypeEnum::toValues(),
            'viewpoints' => new ThreeSixtyViewpointCollection($area->viewpoints),
        ]);
    }

    public function edit(Area $area, Viewpoint $viewpoint, Clickpoint $clickpoint): Response
    {
        return Inertia::render('Admin/ThreeSixtyGenerator/Clickpoints/Edit', [
            'area' => new ThreeSixtyAreaResource($area, true),
            'viewpoint' => new ThreeSixtyViewpointResource($viewpoint),
            'clickpoint' => new ThreeSixtyClickpointResource($clickpoint, true),
            'contentTypes' => ContentTypeEnum::toValues(),
            'viewpoints' => new ThreeSixtyViewpointCollection($area->viewpoints),
        ]);
    }

    public function update(
        ThreeSixtyClickpointRequest $request,
        ClickpointUpdateAction $clickpointUpdateAction,
        Area $area,
        Viewpoint $viewpoint,
        Clickpoint $clickpoint
    ): RedirectResponse {
        // Authorize
        $this->authorize('update', $clickpoint);

        // Validate input
        $validated = $request->validated();

        // Handle action
        $clickpointUpdateAction->handle($validated, $viewpoint, $clickpoint);

        // Return
        return redirect()
            ->route('admin.three-sixty-generator.clickpoint.index', [
                'area' => $area,
                'viewpoint' => $viewpoint,
            ])
            ->with('success', trans('spa.toasts.description.three_sixty_viewpoint_updated'));
    }

    public function destroy(
        ClickpointDestroyAction $clickpointDestroyAction,
        Area $area,
        Viewpoint $viewpoint,
        Clickpoint $clickpoint
    ): RedirectResponse {
        // Authorize
        $this->authorize('delete', $clickpoint);

        // Handle action
        $clickpointDestroyAction->handle($clickpoint);

        // Return
        return redirect()
            ->route('admin.three-sixty-generator.clickpoint.index', [
                'area' => $area,
                'viewpoint' => $viewpoint,
            ])
            ->with('success', trans('spa.toasts.description.three_sixty_clickpoint_deleted'));
    }
}
