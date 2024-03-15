<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ThreeSixtyAreaResource extends JsonResource
{
    protected bool $addViewpoints = false;

    protected bool $allTranslations = false;

    public function __construct($resource, $addViewpoints = false, $allTranslations = false)
    {
        parent::__construct($resource);
        $this->addViewpoints = $addViewpoints;
        $this->allTranslations = $allTranslations;
    }

    public function toArray(Request $request): array
    {
        if (! $this->addViewpoints) {
            return [
                'id' => $this->id,
                'name' => $this->allTranslations ? $this->resource->getTranslations('name') : $this->name,
            ];
        }

        return [
            'id' => $this->id,
            'name' => $this->allTranslations ? $this->resource->getTranslations('name') : $this->name,
            'viewpoints' => new ThreeSixtyViewpointCollection($this->viewpoints, $this->allTranslations),
        ];
    }
}
