<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use \Google\Client;

use Socialite;

use App\Models\User;
use App\Models\Activity;
use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;

use Illuminate\Support\Facades\Auth;

class GoogleCalendarController extends Controller
{
    // redirect to google oauth
    // public function redirect()
    // {
    //     return Socialite::driver('google')
    //         ->scopes(['https://www.googleapis.com/auth/calendar', 'https://www.googleapis.com/auth/calendar.events'])
    //         ->redirect();
    // }
    
    // // callback called from google calendar, stores the 
    // public function callback()
    // {
    //     $googleUser = Socialite::driver('google')->user();
    //     // $json = json_encode($googleUser->token);

    //     $json_arr = [
    //         'access_token' => $googleUser->token,
    //         'expires_in' => $googleUser->expiresIn,
    //         'scope' => ''
    //     ];

    //     $user = User::firstWhere('email', $googleUser->getEmail());

    //     // Save the token in user DB
    //     $user->google_token = json_encode($googleUser);
    //     $user->save();

    //     exit();
    // }

    public function redirect()
    {
        try {
            $client = new Google_Client();
            $client->setApplicationName('Google Calendar API PHP Quickstart');
            $client->setScopes(Google_Service_Calendar::CALENDAR, Google_Service_Calendar::CALENDAR_EVENTS);
            $client->setAuthConfig(storage_path('app/google-calendar/oauth-credentials.json'));
            $client->setAccessType('offline');
            $client->setPrompt('select_account consent');

            // Request authorization from the user.
            $authUrl = $client->createAuthUrl();

            return redirect($authUrl);
        } catch (\Exception $ex){
            return redirect()->back()->withErrors($ex->getMessage());
        }
    }
    
    
    public function callback(){
        try{
            $authCode = $_GET['code'];

            // Exchange authorization code for an access token.
            $client = new Google_Client();
            $client->setApplicationName('Google Calendar API PHP Quickstart');
            $client->setScopes(Google_Service_Calendar::CALENDAR, Google_Service_Calendar::CALENDAR_EVENTS);
            $client->setAuthConfig(storage_path('app/google-calendar/oauth-credentials.json'));
            $client->setAccessType('offline');
            $client->setPrompt('select_account consent');

            $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
            
            $client->setAccessToken($accessToken);

            // Save token in DB
            $user = $this->_getCurrentUser();
            $json = json_encode($accessToken);
            $user->google_token = json_encode($accessToken);
            $user->save();  
            
            // Redirect to settings
            return redirect('/settings')->with(['success' => 'Account connected to Google Calendar successfully!']);
        } catch (\Exception $ex){
            return redirect('/settings')->withErrors($ex->getMessage());
        }
    }


    public function getClient(User $user)
    {
        try{
            $client = new Google_Client();
            $client->setApplicationName('Google Calendar API PHP Quickstart');
            $client->setScopes(Google_Service_Calendar::CALENDAR, Google_Service_Calendar::CALENDAR_EVENTS);
            $client->setAuthConfig(storage_path('app/google-calendar/oauth-credentials.json'));
            $client->setAccessType('offline');
            $client->setPrompt('select_account consent');

            $accessToken = $user->google_token;
            $client->setAccessToken($accessToken);

            return $client;
        } catch (\Exception $ex){
            error_log($ex->getMessage());
            return null;
        }
    }



    public function publish(Request $request, $id) 
    {
        try {
            $activity = Activity::find($id);

            if (Auth::user()->cannot('creator', $activity)) {
                return redirect()->back()->withErrors(['error' => 'You are not authorized to do this action']);
            }

            // if ($activity->published){
            //     return redirect()->back()->withErrors('Activity is already published in google calendar');
            // }

            $user = $this->_getCurrentUser();
            $client = $this->getClient($user);
            if ($client===null){
                throw new \Exception("Unable to get google client. Make sure your account is connected to Google Calendar in Settings Panel");
            }
            $service = new Google_Service_Calendar($client);


            $begins_at = date_create($activity->begins_at);
            $ends_at = date_create($activity->ends_at);
            $event = new Google_Service_Calendar_Event(array(
                'summary' => 'asdfasd',
                'location' => 'Av. Emili Vallès, 4, 08700 Igualada, Barcelona',
                'description' => $activity->description,
                'start' => array(
                'dateTime' => date_format($begins_at,"Y-m-d") . "T" .date_format($begins_at,"H:i:sP"),
                'timeZone' => 'Europe/Madrid',
                ),
                'end' => array(
                    'dateTime' => date_format($ends_at,"Y-m-d") . "T" .date_format($ends_at,"H:i:sP"),
                    'timeZone' => 'Europe/Madrid',
                ),
                'recurrence' => array(
                'RRULE:FREQ=DAILY;COUNT=2'
                ),
            ));
        
            $calendarId = 'primary';
            $event = $service->events->insert($calendarId, $event);

            
            // Update DB
            $activity->published = true;
            $activity->save();

            return redirect()->back()->with(['success' => 'Activity published in Google Calendar successfully']);
        } catch (\Exception $ex){
            return redirect()->back()->withErrors($ex->getMessage());
        }
    }
    




}
