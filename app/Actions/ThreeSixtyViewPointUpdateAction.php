<?php

namespace App\Actions;

use App\Models\ThreeSixtyViewPoint;

class ThreeSixtyViewPointUpdateAction
{
    public function handle(array $data, ThreeSixtyViewPoint $viewPoint): void
    {
        // Create record
        $model = ThreeSixtyViewPoint::updateOrCreate(['id' => $viewPoint->id], [
            'name' => $data['name'],
            'description' => $data['description'],
            'is_default' => $data['is_default'],
        ]);

        if($data['new_image']) {
            // Remove previous media
            $model
                ->getFirstMedia('viewpoints')
                ?->delete();

            // Add new media
            $model->addMedia($data['new_image'])->toMediaCollection('viewpoints', 'assets');
        }
    }
}
