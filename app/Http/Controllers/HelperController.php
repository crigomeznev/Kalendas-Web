<?php

namespace App\Http\Controllers;

use App\Models\Helper;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Mail\InviteEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class HelperController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect('/app');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $email = $request->input('newHelper'); 
        $user = User::firstWhere('email', $email);
        $message = null;

        if (is_null($user)){
            // Si usuari no existeix: crear usuari amb estat bloquejat
            // i enviar mail d'invitació
            $user = User::create([
                'name' => 'New user',
                'lastname' => 'New user',
                'email' => $email,
                'password' => '',
                'birthdate' => date_create('1970-01-01'),
                // 'birthdate' => strtotime('1970-01-01'),
                'gender' => 'not_specified',
                'blocked' => true
            ]);

            Mail::to($email)->send(new InviteEmail(Auth::user(), $email));
            $message = "User {$email} is not registered yet. A mail has been sent to him/her to register in Kalendas app.<br>";
        }

        $fields = [
            'calendar_id' => session('calendar')->id,
            'user_id' => $user->id
        ];

        $validator = Validator::make($fields, [
            'calendar_id' => 'required',
            'user_id' => 'required',
        ]);
 
        if ($validator->fails()) {
            return redirect('/calendars')
                        ->withErrors($validator)
                        ->withInput();
        }

        Helper::create($fields);
        $message .= "Helper added successfully";

        return redirect(route('calendars.edit', session('calendar')->id))->with(['success' => $message]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Helper $helper)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Helper $helper)
    {
        $this->authorize('owner', $helper);

        $helper->delete();

        return redirect(route('calendars.edit', session('calendar')->id));
    }
}
