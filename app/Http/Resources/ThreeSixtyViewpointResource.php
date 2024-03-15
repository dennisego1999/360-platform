<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ThreeSixtyViewpointResource extends JsonResource
{
    protected bool $addClickpoints = false;
    protected bool $allTranslations = false;

    public function __construct($resource, $addClickpoints = false, $allTranslations = false)
    {
        parent::__construct($resource);
        $this->addClickpoints = $addClickpoints;
        $this->allTranslations = $allTranslations;
    }

    public function toArray(Request $request): array
    {
        if (! $this->addClickpoints) {
            return [
                'id' => $this->id,
                'name' => $this->resource->getTranslations('name'),
                'description' => $this->resource->getTranslations('description'),
                'initial_view' => $this->initial_view,
                'is_default' => $this->is_default,
                'image' => new MediaResource($this->getFirstMedia('viewpoints')),
            ];
        }

        return [
            'id' => $this->id,
            'name' => $this->resource->getTranslations('name'),
            'description' => $this->resource->getTranslations('description'),
            'initial_view' => $this->initial_view,
            'is_default' => $this->is_default,
            'image' => new MediaResource($this->getFirstMedia('viewpoints')),
            'clickpoints' => new ThreeSixtyClickpointCollection($this->clickpoints, $this->allTranslations),
        ];
    }
}
