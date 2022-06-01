<?php

namespace App\Policies;

use App\Models\Calendar;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CalendarPolicy
{
    use HandlesAuthorization;

    public function owner(User $user, Calendar $calendar)
    {
        return $calendar->owner_id === $user->id;
    }

    public function hasAccess(User $user, Calendar $calendar)
    {
        return $calendar->owner_id === $user->id || $calendar->helpers->firstWhere('user_id', $user->id)!==null;
    }

}
