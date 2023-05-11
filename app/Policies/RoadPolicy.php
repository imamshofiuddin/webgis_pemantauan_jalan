<?php

namespace App\Policies;

use App\Models\Place;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RoadPolicy
{
    use HandlesAuthorization;
    /**
     * Create a new policy instance.
     */

    public function view(User $user, Place $place)
    {
        return true;
    }

    public function create(User $user, Place $place)
    {
        return true;
    }

    public function update(User $user, Place $place)
    {
        return true;
    }

    public function delete(User $user, Place $place)
    {
        return true;
    }
}
