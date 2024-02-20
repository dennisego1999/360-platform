<?php

namespace App\Actions;

use App\Models\Viewpoint;

class ViewpointUpdateAction
{
    public function handle(array $data, Viewpoint $viewpoint): void
    {
        // Create record
        $model = Viewpoint::updateOrCreate(['id' => $viewpoint->id], [
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
