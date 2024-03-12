<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;

class ThreeSixtyAreaCollection extends ResourceCollection
{
    protected bool $allTranslations = false;

    public function __construct($resource, $allTranslations = false)
    {
        parent::__construct($resource);
        $this->allTranslations = $allTranslations;
    }

    public function toArray(Request $request): Collection
    {
        return $this->collection->map(function ($item) use ($request) {
            return (new ThreeSixtyAreaResource($item, $this->allTranslations))
                ->toArray($request);
        });
    }
}
