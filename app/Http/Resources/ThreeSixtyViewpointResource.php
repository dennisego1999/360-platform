<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ThreeSixtyViewpointResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->resource->getTranslations('name'),
            'description' => $this->resource->getTranslations('description'),
            'is_default' => $this->is_default,
            'image' => new MediaResource($this->getFirstMedia('viewpoints')),
        ];
    }
}
