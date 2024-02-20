<?php

namespace App\Actions;

use App\Models\ThreeSixtyArea;

class ThreeSixtyAreaCreateAction
{
    public function handle(array $data): void
    {
        // Create record
        ThreeSixtyArea::create([
            'name' => $data['name'],
        ]);
    }
}
