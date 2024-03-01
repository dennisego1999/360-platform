<?php

namespace App\Actions;

use App\Models\Clickpoint;
use App\Models\Viewpoint;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class ClickpointUpdateAction
{
    private ClickpointProcessContentAction $clickpointProcessContentAction;

    public function __construct(ClickpointProcessContentAction $clickpointProcessContentAction) {
        $this->clickpointProcessContentAction = $clickpointProcessContentAction;
    }

    public function handle(
        array $data,
        Viewpoint $viewpoint,
        Clickpoint $clickpoint,
    ): void
    {
        foreach (LaravelLocalization::getSupportedLanguagesKeys() as $locale) {
            // Process clickpoint content
            $data['content'][$locale] = $this->clickpointProcessContentAction->handle(
                $data['content'][$locale],
                $data['content_type']
            );
        }

        // Create record
        Clickpoint::updateOrCreate(['id' => $clickpoint->id], [
            'name' => $data['name'],
            'coordinates' => $data['coordinates'],
            'content' => $data['content'] ?? null,
            'content_type' => $data['content_type'],
            'viewpoint_id' => $viewpoint->id
        ]);
    }
}
