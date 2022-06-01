<?php

namespace App\Policies;

use App\Models\Helper;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class HelperPolicy
{
    use HandlesAuthorization;

    public function owner(User $user, Helper $helper)
    {
        error_log('user id ='.$user->id);
        error_log('creator id ='.$helper->calendar->owner_id);
        return $helper->calendar->owner_id == $user->id;
    }
}
