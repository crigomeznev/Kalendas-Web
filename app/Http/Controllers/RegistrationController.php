<?php

namespace App\Http\Controllers;

use App\Mail\VerifyEmail;
use App\Models\Country;
use App\Models\Gender;
use App\Models\User;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class RegistrationController extends Controller
{
    public function create($email = null)
    {
        $data = array(
            'countries' => Country::all(),
            'genders' => Gender::values(),
            'email' => $email
        );
        return view('registration.create', $data);
    }

    public function store(Request $request)
    {
        $this->validate(request(), [
            'name' => 'required|min:3',
            'lastname' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:3',
            'birthdate' => 'required|date',
            'gender' => 'required',
            'country' => 'required'
        ]);
        
        $fields = request(['name', 'lastname', 'email', 'password', 'birthdate', 'gender']);
        $fields['country_id'] = Country::firstWhere('code', $request->input('country'))->id;
        $fields['blocked'] = 1; // unblocked when user verifies email
        $fields['password'] = bcrypt($fields['password']);
        $user = User::create($fields);
    
        // TODO: enviar mail
        Mail::to($request->input('email'))->send(new VerifyEmail($user));

        return redirect('/')->with('success', 'An email has been sent to your address. Please verify it to register');
    }


    public function edit ($hash)
    {
        try {
            $email = Crypt::decrypt($hash);
    
            return view('registration.edit', ['email' => $email, 'hash' => $hash]);

        } catch (DecryptException $ex) {
            return response()->json([
                'message' => 'Error: invalid url',
            ], 401);
        }
    }


    /**
     * For invited users: register in application
     */
    public function update (Request $request, $email)
    {
        $user = User::firstWhere('email', $email);

        $this->validate(request(), [
            'name' => 'required|min:3',
            'lastname' => 'required|min:3',
            'password' => 'required|min:3',
            'birthdate' => 'required|date',
            'gender' => 'required',
            'country' => 'required'
        ]);
        
        $fields = request(['name', 'lastname', 'email', 'password', 'birthdate', 'gender']);
        $fields['country_id'] = Country::firstWhere('code', $request->input('country'))->id;
        $fields['blocked'] = true; // unblocked when user verifies email
        $fields['password'] = bcrypt($fields['password']);

        $user->name = $fields['name'];
        $user->lastname = $fields['lastname'];
        $user->password = $fields['password'];
        $user->birthdate = $fields['birthdate'];
        $user->gender = $fields['gender'];
        $user->country_id = $fields['country_id'];
        $user->blocked = $fields['blocked'];

        $user->save();
    
        // TODO: enviar mail
        Mail::to($email)->send(new VerifyEmail($user));

        return redirect('/')->with('success', 'An email has been sent to your address. Please verify it to register');
    }



    /**
     * Validate account via email
     */
    public function confirm (Request $request)
    {
        $request->validate([
            'password' => 'required|min:3'
        ]);
    
        $user = User::firstWhere('email', $request->input('email'));
    
        if (!Auth::attempt( ['email' => $request->input('email'), 'password' => $request->input('password')])) {
            return redirect()->back()->withErrors(['Wrong password']);
        }
    
        echo "password ok";
    
        $user->blocked = false;
        $user->save();

        return redirect('/')->with(['success' => 'Your account was validated successfully! You can now log in']);
    }





}
