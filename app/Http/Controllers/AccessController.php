<?php

namespace App\Http\Controllers;

use App\Models\Calendar;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use ReallySimpleJWT\Token;

class AccessController extends Controller
{
    public function index()
    {
        if (session('token')!==null){
            return redirect('/calendars');
        }

        return view('login');
    }

    public function settings()
    {
        return view('settings', $this->_loadData());
    }



    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)){
            $request->session()->regenerate();
            $this->_loadSession($request);

            return redirect()->intended('/calendars');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.'
        ]);

        // $request->validate([
        // ]);
 
        // $user = User::where('email', $request->input('email'))->first();

        // if (is_null($user)){
        //     return back()->withErrors([
        //         'email' => 'There is no user with this email.',
        //     ])->onlyInput('email');        
        // }

        // if (!Hash::check($request->input('password'), $user->password)){
        //     return back()->withErrors([
        //         'password' => 'Password is incorrect.',
        //     ])->onlyInput('email');
        // }




        return redirect('/calendars');
    }


    protected function _loadSession(Request $request)
    {
        $user = Auth::user();

        // Get token and save it in SESSION
        // TODO: SAVE IN CONF FILE
        $payload = [
            'user' => $user->email,
            'iat' => time(),
            'exp' => time() + config('kalendas.web-expiration'),
            'iss' => 'localhost'
        ];

        // TODO: QUE HACE ESTO AQUI!!!!!
        $token = Token::customPayload($payload, config('kalendas.token-secret'));

        $request->session()->put('token', $token);

        // Load session data: By default, current calendar is the first in the list or none
        $curCalendar = $user->calendars->count()==0 ? null : $user->calendars[0];
        $request->session()->put('calendar', $curCalendar);
    }



    public function logout(Request $request)
    {
        $request->session()->forget('curCalendar');
        $request->session()->forget('token');
        $request->session()->invalidate();
        
        return redirect('/');
    }
}
