<?php

namespace App\Policies;

use App\Models\ThreeSixtyArea;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ThreeSixtyAreaPolicy
{
    use HandlesAuthorization;

    public function viewAny(): bool
    {
        return true;
    }

    public function view(): bool
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
