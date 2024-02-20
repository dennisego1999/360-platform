<?php

namespace App\Actions;

use App\Models\ThreeSixtyArea;

class ThreeSixtyAreaUpdateAction
{
    public function handle(array $data, ThreeSixtyArea $threeSixtyArea): void
    {
        // Create record
        $model = ThreeSixtyArea::updateOrCreate(['id' => $threeSixtyArea->id], [
            'name' => $data['name'],
            'slug' => $data['slug'],
        ]);

        if($data['new_image']) {
            // Remove previous media
            $model
                ->getFirstMedia('three-sixty-areas')
                ?->delete();

            // Add new media
            $model->addMedia($data['new_image'])->toMediaCollection('three-sixty-areas', 'assets');
        }
    }
}
