<?php

namespace App\Actions;


use App\Enums\ContentTypeEnum;

class ClickpointProcessContentAction
{
    public function handle(array $data, string $contentType): ?array
    {
        $content = null;

        if($contentType === ContentTypeEnum::LINK_TO_VIEWPOINT()->value) {
            $content = collect($data)->only(['viewpoint_id'])->toArray();
        }

        if($contentType === ContentTypeEnum::VIDEO()->value) {
            $content = collect($data)->only(['video'])->toArray();
        }

        if($contentType === ContentTypeEnum::INFO()->value) {
            $content = collect($data)->only(['info'])->toArray();
        }

        if($contentType === ContentTypeEnum::INERTIA_ROUTE()->value) {
            $content = collect($data)->only(['inertia_route'])->toArray();
        }

        if($contentType === ContentTypeEnum::EXTERNAL_URL()->value) {
            $content = collect($data)->only(['external_url'])->toArray();
        }

        return $content;
    }
}
