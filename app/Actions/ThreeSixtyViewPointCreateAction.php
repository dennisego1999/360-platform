<?php

namespace App\Actions;

use App\Models\ThreeSixtyArea;
use App\Models\ThreeSixtyViewPoint;

class ThreeSixtyViewPointCreateAction
{
    public function handle(array $data, ThreeSixtyArea $threeSixtyArea): void
    {
        // Create record
        $model = ThreeSixtyViewPoint::create([
            'name' => $data['name'],
            'description' => $data['description'],
            'is_default' => $data['is_default'],
            'three_sixty_area_id' => $threeSixtyArea['id'],
        ]);

        if($data['new_image']) {
            $model
                ->addMedia($data['new_image'])
                ->toMediaCollection('viewpoints', 'assets');
        }
    }
}
