<?php

namespace App\Actions;

use App\Models\Viewpoint;

class ViewpointDestroyAction
{
    public function handle(Viewpoint $viewpoint): void
    {
        // Delete
        $viewpoint->delete();
    }
}
