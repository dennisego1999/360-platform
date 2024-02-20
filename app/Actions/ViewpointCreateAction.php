<?php

namespace App\Actions;

use App\Models\Area;
use App\Models\Viewpoint;

class ViewpointCreateAction
{
    public function handle(array $data, Area $area): void
    {
        // Create record
        $model = Viewpoint::create([
            'name' => $data['name'],
            'description' => $data['description'],
            'is_default' => $data['is_default'],
            'area_id' => $area['id'],
        ]);

        if($data['new_image']) {
            $model
                ->addMedia($data['new_image'])
                ->toMediaCollection('viewpoints', 'assets');
        }
    }
}
