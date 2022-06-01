<?php

namespace App\Policies;

use App\Models\Activity;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ActivityPolicy
{
    use HandlesAuthorization;

    /**
     * Returns true if user is the owner of the activity's calendar
     */
    public function owner(User $user, Activity $activity)
    {
        return $activity->calendar->owner_id == $user->id;
    }

    /**
     * Returns true if user is the creator of the activity
     */
    public function creator(User $user, Activity $activity)
    {
        return $activity->calendar->owner_id == $user->id || $activity->creator_id == $user->id;
    }
}
