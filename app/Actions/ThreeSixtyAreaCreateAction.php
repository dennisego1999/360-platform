<?php

namespace App\Actions;

use App\Models\ThreeSixtyArea;

class ThreeSixtyAreaCreateAction
{
    public function handle(array $data): void
    {
        ThreeSixtyArea::create([
            'name' => $data['name'],
            'slug' => $data['slug'],
        ]);
    }
}
