<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ThreeSixtyClickpointResource extends JsonResource
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
            'coordinates' => $this->coordinates,
            'content' => $this->allTranslations ? $this->resource->getTranslations('content') : $this->content,
            'content_type' => $this->content_type,
        ];
    }
}
