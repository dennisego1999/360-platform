<?php

namespace App\Actions;

use App\Models\Area;

class AreaCreateAction
{
    public function handle(array $data): void
    {
        // Create record
        Area::create([
            'name' => $data['name'],
        ]);
    }
}
