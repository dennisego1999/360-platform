<?php

namespace App\Actions;

use App\Models\Area;

class AreaUpdateAction
{
    public function handle(array $data, Area $threeSixtyArea): void
    {
        // Create record
        Area::updateOrCreate(['id' => $threeSixtyArea->id], [
            'name' => $data['name'],
        ]);
    }
}
