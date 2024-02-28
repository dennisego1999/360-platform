<?php

namespace App\Actions;

use App\Models\Clickpoint;

class ClickpointDestroyAction
{
    public function handle(Clickpoint $clickpoint): void
    {
        // Delete
        $clickpoint->delete();
    }
}
