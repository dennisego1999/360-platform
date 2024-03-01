<?php

namespace App\Policies;

use App\Models\Clickpoint;
use App\Models\User;

class ClickpointPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Clickpoint $clickpoint): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->can('manage-three-sixties');
    }

    public function update(User $user): bool
    {
        return $user->can('manage-three-sixties');
    }

    public function delete(User $user): bool
    {
        return $user->can('manage-three-sixties');
    }

    public function restore(User $user): bool
    {
        return $user->can('manage-three-sixties');
    }

    public function forceDelete(User $user): bool
    {
        return $user->can('manage-three-sixties');
    }
}
