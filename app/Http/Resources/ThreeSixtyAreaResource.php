<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ThreeSixtyAreaResource extends JsonResource
{
    protected bool $allTranslations = false;

    public function __construct($resource, $allTranslations = false)
    {
        parent::__construct($resource);
        $this->allTranslations = $allTranslations;
    }

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->allTranslations ? $this->resource->getTranslations('name') : $this->name,
            'viewpoints' => ThreeSixtyViewpointResource::collection($this->viewpoints)
        ];
    }
}
