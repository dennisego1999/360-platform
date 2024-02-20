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
            'name' => $this->name,
            'description' => $this->description,
            'is_default' => $this->is_default,
            'image' => new MediaResource($this->getFirstMedia('viewpoints')),
        ];
    }
}
