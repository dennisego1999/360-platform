<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;

class ThreeSixtyViewpointCollection extends ResourceCollection
{
    protected bool $addClickpoints = false;
    protected bool $allTranslations = false;

    public function __construct($resource, $addClickpoints = false, $allTranslations = false)
    {
        parent::__construct($resource);
        $this->addClickpoints = $addClickpoints;
        $this->allTranslations = $allTranslations;
    }

    public function toArray(Request $request): Collection
    {
        return $this->collection->map(function ($item) use ($request) {
            return (new ThreeSixtyViewpointResource($item, $this->addClickpoints, $this->allTranslations))
                ->toArray($request);
        });
    }
}
