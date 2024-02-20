<?php

namespace App\Actions;

use App\Models\ThreeSixtyViewPoint;

class ThreeSixtyViewPointDestroyAction
{
    public function handle(ThreeSixtyViewPoint $viewPoint): void
    {
        // Delete
        $viewPoint->delete();
    }
}
