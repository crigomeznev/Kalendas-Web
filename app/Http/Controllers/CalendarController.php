<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Calendar;
use App\Models\Helper;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Spatie\GoogleCalendar\Event;

class CalendarController extends Controller
{
    public function index()
    {
        $calendar = session('calendar');
        if (is_null($calendar)) {
            return redirect('/settings');
        }
        return redirect("/calendars/{$calendar->id}");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Calendar $calendar)
    {
        if (Auth::user()->cannot('hasAccess', $calendar)) {
            return redirect()->back()->withErrors(['error' => 'You are not authorized to do this action']);
        }

        $data = $this->_loadData($calendar->id);

        // DB::enableQueryLog();
        if (!Session::has('date')) {
            // var_dump(DB::getQueryLog());
            // exit();
            $data['activities'] = Activity::where('calendar_id', $calendar->id)
                ->orderBy('begins_at', 'desc')->limit(10)
                ->get();
        } else {
            $selectedDate = DateTime::createFromFormat('Y-m-d', Session::get('date'));
            // var_dump(session('date'));
            // echo "<hr>";
            // echo "day: ".$selectedDate->format('d');
            // echo "month: ".$selectedDate->format('m');
            // echo "year: ".$selectedDate->format('Y');
            // exit();
            $data['activities'] = Activity::where('calendar_id', $calendar->id)
                ->whereYear('begins_at', '=', $selectedDate->format('Y'))
                ->whereMonth('begins_at', '=', $selectedDate->format('m'))
                ->whereDay('begins_at', '=', $selectedDate->format('d'))
                ->get();


            $data['selectedDate'] = session('date');
        }

        // $data['events'] = Event::get();
        return view('calendars.show', $data);
    }


    public function edit(Calendar $calendar)
    {
        if (Auth::user()->cannot('owner', $calendar)) {
            return redirect()->back()->withErrors(['error' => 'You are not authorized to do this action']);
        }

        $data = $this->_loadData();

        $data['calendar']->load('helpers');
        $data['calendar']->load('targets');

        return view('calendars.edit', $data);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:3|unique:calendars'
        ]);
        if ($validator->fails()) {
            return redirect(route('settings'))
                ->withErrors($validator)
                ->withInput();
        }

        Calendar::create([
            'title' => $request->input('title'),
            'owner_id' => $this->_getCurrentUser()->id
        ]);

        return redirect('/settings');
    }


    public function update(Request $request, Calendar $calendar)
    {
        if (Auth::user()->cannot('owner', $calendar)) {
            return redirect()->back()->withErrors(['error' => 'You are not authorized to do this action']);
        }
    }



    // AJAX
    public function switch(Request $request)
    {
        $id = $request->input('id');
        $calendar = Calendar::find($id);

        if (is_null($calendar)) {
            return response()->json([
                'message' => "Error: calendar with id {$id} not found",
            ], 404);
        }

        // $request->session()->put('calendar', $calendar);
        Session::put(['calendar' => $calendar]);
        Session::save();
        // session(['calendar' => $calendar]);

        // var_dump($calendar);
        // exit();

        $calendar = Session::get('calendar');


        return response()->json([
            'message' => "Successfully switched to calendar id {$calendar->id} - {$calendar->title}",
        ], 200);
    }



    public function date(Request $request)
    {
        $date = $request->input('date');

        if (is_null($date)) {
            Session::remove('date');
            // return response()->json([
            //     'message'=> "Error: date required",
            // ], 404);
            return response()->json([
                'message' => "unset selected date",
            ], 200);            
        } else {

            // $request->session()->put('calendar', $calendar);
            Session::put(['date' => $date]);
            Session::save();
            // session(['calendar' => $calendar]);

            // var_dump($calendar);
            // exit();

            // $calendar = Session::get('calendar');


            return response()->json([
                'message' => "date: {$date}",
            ], 200);
        }
    }
}
