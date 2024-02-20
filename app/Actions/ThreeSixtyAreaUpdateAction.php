<?php

namespace App\Actions;

use App\Models\ThreeSixtyArea;

class ThreeSixtyAreaUpdateAction
{
    public function handle(array $data, ThreeSixtyArea $threeSixtyArea): void
    {
        // Create record
        ThreeSixtyArea::updateOrCreate(['id' => $threeSixtyArea->id], [
            'name' => $data['name'],
        ]);
    }
}
