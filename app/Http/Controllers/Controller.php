<?php

namespace App\Http\Controllers;

use App\Models\Calendar;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use ReallySimpleJWT\Decode;
use ReallySimpleJWT\Jwt;
use ReallySimpleJWT\Parse;
use ReallySimpleJWT\Token;

use App\Models\User;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    /**
     * Functions that all controllers use
     */

    /**
     * Gets current user with the token data
     */
    protected function _getCurrentUser($token = null)
    {
        if (is_null($token)){
            $parser = new Parse(new Jwt(session('token')), new Decode());
        } else {
            $parser = new Parse(new Jwt($token), new Decode());
        }

        $parsedToken = $parser->parse();
        $email = $parsedToken->getPayload()['user'];

        return User::where('email', $email)->first();
    }


    /**
     * Returns user's first available calendar, either owned or helped
     */
    protected function _getDefaultCalendar()
    {
        $user = $this->_getCurrentUser();

        // First get first owned calendar
        if ($user->calendars->count()>0){
            return $user->calendars[0];
        }

        // If it hasn't any, get first helped calendar
        if ($user->helps->count()>0){
            return $user->helps[0]->calendar;
        }

        // Otherwise return null
        return null;
    }


    protected function _loadData($calendar_id = null)
    {
        $user = $this->_getCurrentUser();

        // Change selected calendar
        if (!is_null($calendar_id)){
            session(['calendar' => Calendar::find($calendar_id)]);
        }

        $data = [
            'user' => $user,
            'calendars' => $user->calendars,
            'calendar' => session('calendar'),
            'categories' => $user->categories,
        ];

        // TODO: move to overwrite
        if (!is_null($data['calendar'])){
            // Who can be helper of my calendar? not me and people who are not helper yet
            // $cannotBeHelpers = array_map(function($helper) { return $helper->id; }, $data['helpers']->toArray());
            $cannotBeHelpers = array_column($data['calendar']->helpers->toArray(), 'user_id');
            array_push($cannotBeHelpers, $user->id);

            $data['nonHelpers'] = User::whereNotIn('id', $cannotBeHelpers)->get();
        }

        return $data;
    }    

}
