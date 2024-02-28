<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ThreeSixtyClickpointResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->resource->getTranslations('name'),
            'coordinates' => $this->coordinates,
            'content' => $this->resource->getTranslations('content'),
            'content_type' => $this->content_type,
        ];
    }
}
