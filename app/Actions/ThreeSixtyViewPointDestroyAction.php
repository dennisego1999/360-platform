<?php

namespace App\Actions;

use App\Models\ThreeSixtyViewPoint;

class ThreeSixtyViewPointDestroyAction
{
    public function handle(ThreeSixtyViewPoint $threeSixtyViewPoint): void
    {
        // Delete
        $threeSixtyViewPoint->delete();
    }
}
