<?php

namespace App\Http\Controllers\Admin;

use App\Actions\AreaCreateAction;
use App\Actions\AreaDestroyAction;
use App\Actions\AreaUpdateAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\ThreeSixtyAreaRequest;
use App\Http\Resources\ThreeSixtyAreaCollection;
use App\Http\Resources\ThreeSixtyAreaResource;
use App\Models\Area;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class AreaController extends Controller
{
    public function index(): Response
    {
        $areas = Area::all();

        return Inertia::render('Admin/ThreeSixtyGenerator/Area/Index', [
            'areas' => new ThreeSixtyAreaCollection($areas, false),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/ThreeSixtyGenerator/Area/Create');
    }

    public function store(
        ThreeSixtyAreaRequest $request,
        AreaCreateAction $areaCreateAction
    ): RedirectResponse {
        // Authorize
        $this->authorize('create', Area::class);

        // Validate input
        $validated = $request->validated();

        // Handle action
        $areaCreateAction->handle($validated);

        // Return
        return redirect()
            ->route('admin.three-sixty-generator.area.index')
            ->with('success', trans('spa.toasts.description.three_sixty_area_created'));
    }

    public function show(Area $area): Response
    {
        return Inertia::render('Admin/ThreeSixtyGenerator/Area/Show', [
            'area' => new ThreeSixtyAreaResource($area, true),
        ]);
    }

    public function edit(Area $area): Response
    {
        return Inertia::render('Admin/ThreeSixtyGenerator/Area/Edit', [
            'area' => new ThreeSixtyAreaResource($area, true),
        ]);
    }

    public function update(
        ThreeSixtyAreaRequest $request,
        AreaUpdateAction $areaUpdateAction,
        Area $area
    ): RedirectResponse {
        // Authorize
        $this->authorize('update', $area);

        // Validate input
        $validated = $request->validated();

        // Handle action
        $areaUpdateAction->handle($validated, $area);

        // Return
        return redirect()
            ->route('admin.three-sixty-generator.area.index')
            ->with('success', trans('spa.toasts.description.three_sixty_area_updated'));
    }

    public function destroy(
        AreaDestroyAction $areaDestroyAction,
        Area $area
    ): RedirectResponse {
        // Authorize
        $this->authorize('delete', $area);

        // Handle action
        $areaDestroyAction->handle($area);

        // Return
        return redirect()
            ->route('admin.three-sixty-generator.area.index')
            ->with('success', trans('spa.toasts.description.three_sixty_area_deleted'));
    }
}
