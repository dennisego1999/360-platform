<?php

namespace App\Actions;

use App\Models\Area;

class AreaDestroyAction
{
    public function handle(Area $threeSixtyArea): void
    {
        // Delete
        $threeSixtyArea->delete();
    }
}
