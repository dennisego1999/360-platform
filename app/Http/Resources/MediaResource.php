<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MediaResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'collection_name' => $this->collection_name,
            'custom_properties' => $this->custom_properties,
            'file_name' => $this->file_name,
            'uuid' => $this->uuid,
            'mime_type' => $this->mime_type,
            'original_url' => $this->getAvailableUrl(['optimized']),
            'size' => $this->size,
        ];
    }
}
