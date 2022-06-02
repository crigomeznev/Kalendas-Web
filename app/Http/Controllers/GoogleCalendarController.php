<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Google\Google_Client;

use Socialite;


class GoogleCalendarController extends Controller
{
    // redirect to google oauth
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }
    
    // callback called from google calendar, stores the 
    public function callback()
    {
        $googleUser = Socialite::driver('google')->user();
        $json = json_encode($googleUser->token);

        var_dump($json);

        $user = User::firstWhere('email', $googleUser->getEmail());

        echo "<hr>";
        var_dump($user);
    }





}
