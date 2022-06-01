<?php

namespace App\Policies;

use App\Models\Target;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TargetPolicy
{
    use HandlesAuthorization;

    public function owner(User $user, Target $target)
    {
        return $target->calendar->owner_id == $user->id;
    }

    public function ownerImplicit(User $user)
    {
        return session('calendar')->owner_id == $user->id;
    }

}