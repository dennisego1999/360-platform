<?php

namespace App\Actions;

use App\Models\ThreeSixtyArea;

class ThreeSixtyAreaCreateAction
{
    public function handle(array $data): void
    {
        // Create record
        $model = ThreeSixtyArea::create([
            'name' => $data['name'],
            'slug' => $data['slug'],
            'is_default' => $data['is_default']
        ]);

        if($data['new_image']) {
            // Attach media to model
            $model->addMedia($data['new_image'])->toMediaCollection('three-sixty-areas', 'assets');
        }
    }
}
