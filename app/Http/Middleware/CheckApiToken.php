<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use ReallySimpleJWT\Token;
use ReallySimpleJWT\Parse;
use ReallySimpleJWT\Jwt;
use ReallySimpleJWT\Decode;

use App\Models\User;

/**
 * Prevents non validated users to enter the application
 */
class CheckApiToken
{
    /**
     * Handle an incoming request.
     * Prevents non validated users to enter the application
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        error_log('checktoken');
        $secret = config('kalendas.token-secret');

        $token = $request->header('token');

        if (is_null($token) || !Token::validate($token, $secret)){
            return redirect()->back()->withErrors(['error' => 'You need a token to access the application']);
            // return redirect('/');
        }

        // Check expiration time
        $jwt = new Jwt($token, $secret);
        $parse = new Parse($jwt, new Decode());
        $parsed = $parse->parse();
        // Return the token payload claims as an associative array.
        $payload = $parsed->getPayload();

        $user = User::firstWhere('email', $payload['user']);
        if ($user->blocked){
            session()->invalidate();
            return redirect('/')->withErrors(['error' => 'Your user account is blocked']);
        }


        if (time() > $payload['exp']){
            error_log('expired');
            session()->invalidate();
            return redirect('/')->withErrors(['error' => 'Your session has expired. Log in again']);
        }

        return $next($request);
    }
}
