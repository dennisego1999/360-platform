<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;

class ThreeSixtyAreaCollection extends ResourceCollection
{
    protected bool $addViewpoints = false;
    protected bool $allTranslations = false;

    public function __construct($resource, $addViewpoints = false, $allTranslations = false)
    {
        parent::__construct($resource);
        $this->addViewpoints = $addViewpoints;
        $this->allTranslations = $allTranslations;
    }

    public function toArray(Request $request): Collection
    {
        return $this->collection->map(function ($item) use ($request) {
            return (new ThreeSixtyAreaResource($item, $this->addViewpoints, $this->allTranslations))
                ->toArray($request);
        });
    }
}
