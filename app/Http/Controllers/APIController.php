<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\Activity;

use ReallySimpleJWT\Token;
use ReallySimpleJWT\Parse;
use ReallySimpleJWT\Jwt;
use ReallySimpleJWT\Decode;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class APIController extends Controller
{
    public function getToken(Request $request)
    {
        $email = $request->header('email');
        $password = $request->header('password');

        if (!Auth::attempt(['email' => $email, 'password' => $password])){
            return response()->json(array('data' => 'unable to get new token. user and password incorrect'), 401);
        }
        $user = User::firstWhere('email', $email);

        $payload = [
            'iat' => time(),
            'user' => $user->email,
            // 'role' => $user->role,
            'exp' => time() + config('kalendas.api-expiration'),
            'iss' => 'localhost'
        ];
        $token = Token::customPayload($payload, config('kalendas.token-secret'));

        return response()->json(array(
            'token' => $token,
            'message' => 'here is your token'
        ), 200);
    }



    /**
     * Returns activities from date to date of calendars owned by current user
     */
    public function getActivities(Request $request)
    {
        $to = $request->to;
        $from = $request->from;
        // $params = $request->query();
        // $from = $params['$from'];
        // $to = $params['$to'];

        
        $validator = Validator::make(['from' => $from, 'to' => $to], [
            'from' => 'required|date|date_format:Y-m-d',
            'to' => 'required|date|date_format:Y-m-d'
        ]);
        if ($validator->fails()){
            return response()->json(array('data' => 'unable to retrieve activities. from date and to date required'), 500);
        }
        
        if (strtotime($from) > strtotime($to)){
            return response()->json(array('data' => 'unable to retrieve activities. from date must be earlier or equal than to date'), 500);
        }
        
        $user = $this->_getCurrentUser($request->header('token'));
/*
select activities.*, categories.name as c_name, calendars.title as calendar, 'owner' as role
from activities join calendars on activities.calendar_id = calendars.id
				join users on calendars.owner_id = users.id
                left join categories on activities.category_id = categories.id
where users.email = 'cgdomezpruebas@gmail.com'
union
select activities.*, categories.name as c_name, calendars.title as calendar, 'helper' as role
from activities join calendars on activities.calendar_id = calendars.id
                join helpers on calendars.id = helpers.calendar_id
                join users on helpers.user_id = users.id
                left join categories on activities.category_id = categories.id
where users.email = 'cgdomezpruebas@gmail.com';
*/
        $from = date_create($from);
        $to = date_create($to);

        $ownedActivities = DB::table('activities')
                        ->leftJoin('calendars', 'activities.calendar_id', '=', 'calendars.id')
                        ->leftJoin('users', 'calendars.owner_id', '=', 'users.id')
                        ->leftJoin('categories', 'activities.category_id', '=', 'categories.id')
                        ->select(DB::raw("activities.*, categories.name as category, calendars.title as calendar, 'owner' as role"))
                        ->where('users.email', $user->email)
                        ->whereYear('activities.begins_at', '>=', $from->format('Y'))
                        ->whereMonth('activities.begins_at', '>=', $from->format('m'))
                        ->whereDay('activities.begins_at', '>=', $from->format('d'))
                        ->whereYear('activities.ends_at', '<=', $to->format('Y'))
                        ->whereMonth('activities.ends_at', '<=', $to->format('m'))
                        ->whereDay('activities.ends_at', '<=', $to->format('d'))
                        ->orWhere('activities.ends_at', 'is null');

        $helpedActivities = DB::table('activities')
                        ->leftJoin('calendars', 'activities.calendar_id', '=', 'calendars.id')
                        ->leftJoin('helpers', 'calendars.id', '=', 'helpers.calendar_id')
                        ->leftJoin('users', 'helpers.user_id', '=', 'users.id')
                        ->leftJoin('categories', 'activities.category_id', '=', 'categories.id')
                        ->select(DB::raw("activities.*, categories.name as category, calendars.title as calendar, 'helper' as role"))
                        ->where('users.email', $user->email)
                        ->whereYear('activities.begins_at', '>=', $from->format('Y'))
                        ->whereMonth('activities.begins_at', '>=', $from->format('m'))
                        ->whereDay('activities.begins_at', '>=', $from->format('d'))
                        ->whereYear('activities.ends_at', '<=', $to->format('Y'))
                        ->whereMonth('activities.ends_at', '<=', $to->format('m'))
                        ->whereDay('activities.ends_at', '<=', $to->format('d'))
                        ->orWhere('activities.ends_at', 'is null')
                        ->union($ownedActivities)
                        ->get();


        return response()->json(array(
            'data' => $helpedActivities
        ), 200);
        
    }


}
