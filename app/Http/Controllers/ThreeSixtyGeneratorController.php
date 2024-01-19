<?php

namespace App\Http\Controllers;

use App\Actions\ThreeSixtyAreaCreateAction;
use App\Actions\ThreeSixtyAreaDestroyAction;
use App\Actions\ThreeSixtyAreaUpdateAction;
use App\Models\ThreeSixtyArea;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ThreeSixtyGeneratorController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/ThreeSixtyGenerator/Area/Index', [
            'threeSixtyAreas' => ThreeSixtyArea::all(),
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/ThreeSixtyGenerator/Area/Create');
    }

    public function store(Request $request, ThreeSixtyAreaCreateAction $threeSixtyAreaCreateAction)
    {
        // Validate input
        $validated = $request->validate([
            'name' => ['string', 'unique:App\Models\ThreeSixtyArea', 'required', 'max:255'],
            'slug' => ['string', 'unique:App\Models\ThreeSixtyArea', 'required', 'max:255'],
        ]);

        // Handle action
        $threeSixtyAreaCreateAction->handle($validated);

        // Return
        return redirect()
            ->route('admin.three-sixty-generator.index')
            ->with('success', trans('spa.toasts.description.three_sixty_area_created'));
    }

    public function show(ThreeSixtyArea $threeSixtyArea)
    {
        return Inertia::render('Admin/ThreeSixtyGenerator/Area/Show', [
            'area' => $threeSixtyArea
        ]);
    }

    public function edit(ThreeSixtyArea $threeSixtyArea)
    {
        return Inertia::render('Admin/ThreeSixtyGenerator/Area/Edit', [
            'area' => $threeSixtyArea
        ]);
    }

    public function update(Request $request, ThreeSixtyAreaUpdateAction $threeSixtyAreaUpdateAction,ThreeSixtyArea $threeSixtyArea)
    {
        // Authorize
        $this->authorize('update', $threeSixtyArea);

        // Validate input
        $validated = $request->validate([
            'name' => ['string', 'unique:App\Models\ThreeSixtyArea', 'required', 'max:255'],
            'slug' => ['string', 'unique:App\Models\ThreeSixtyArea', 'required', 'max:255'],
        ]);

        // Handle action
        $threeSixtyAreaUpdateAction->handle($validated, $threeSixtyArea);

        // Return
        return redirect()
            ->route('admin.three-sixty-generator.index')
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
            ->route('admin.three-sixty-generator.index')
            ->with('success', trans('spa.toasts.description.three_sixty_area_deleted'));
    }
}
