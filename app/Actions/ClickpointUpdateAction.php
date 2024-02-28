<?php

namespace App\Actions;

use App\Models\Clickpoint;

class ClickpointUpdateAction
{
    public function handle(array $data, Clickpoint $clickpoint): void
    {
        // Create record
        Clickpoint::updateOrCreate(['id' => $clickpoint->id], [
            'name' => $data['name'],
        ]);
    }
}
