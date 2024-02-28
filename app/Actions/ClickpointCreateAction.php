<?php

namespace App\Actions;

use App\Models\Clickpoint;
use App\Models\Viewpoint;

class ClickpointCreateAction
{
    public function handle(array $data, Viewpoint $viewpoint): void
    {
        // Create record
        Clickpoint::create([
            'name' => $data['name'],
            'viewpoint_id' => $viewpoint->id
        ]);
    }
}
