<?php

namespace App\Actions;

use App\Models\ThreeSixtyArea;

class ThreeSixtyAreaDestroyAction
{
    public function handle(ThreeSixtyArea $threeSixtyArea): void
    {
        // Delete
        $threeSixtyArea->delete();
    }
}
