<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('activities.create', $this->_loadData());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'begins_at' => 'required|date',
            'ends_at' => 'nullable|date',
            'title' => 'required|min:2'
        ]);
        
        if ($validator->fails()){
            return redirect(route('activities.create'))
                ->withErrors($validator)
                ->withInput();
        }

        // Check end date after begin date, or null
        $validDates = is_null($request->input('ends_at')) || new DateTime($request->input('begins_at')) < new DateTime($request->input('begins_at'));
        if (!$validDates){
            $errors = new MessageBag();
            $errors->add('Invalid dates', 'Begin date must be earlier than end date');
            return redirect(route('activities.create'))
                ->withErrors($errors)
                ->withInput();
        }

        Activity::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'begins_at' => $request->input('begins_at'),
            'ends_at' => $request->input('ends_at'),
            'latitude' => $request->input('latitude'),
            'longitude' => $request->input('longitude'),
            'calendar_id' => session('calendar')->id,
            'category_id' => $request->input('category_id'),
            'creator_id' => $this->_getCurrentUser()->id
        ]);

        return redirect('/calendars');
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
    public function edit(Activity $activity)
    {
        $user = $this->_getCurrentUser();
        $data = $this->_loadData();

        $begins_at = is_null($activity->begins_at)? "" : date_format(new DateTime($activity->begins_at), 'Y-m-d\TH:i');
        $ends_at = is_null($activity->ends_at)? "" : date_format(new DateTime($activity->ends_at), 'Y-m-d\TH:i');

        $data['activity'] = $activity;
        $data['begins_at'] = $begins_at;
        $data['ends_at'] = $ends_at;

        return view('activities.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Activity $activity)
    {
        if (Auth::user()->cannot('creator', $activity)) {
            return redirect()->back()->withErrors(['error' => 'You are not authorized to do this action']);
        }

        $validator = Validator::make($request->all(), [
            'begins_at' => 'required|date',
            'ends_at' => 'nullable|date'
        ]);
        
        if ($validator->fails()){
            return redirect(route('activities.edit', $activity->id))
            ->withErrors($validator)
            ->withInput();
        }

        // Check end date after begin date, or null
        $validDates = is_null($request->input('ends_at')) || new DateTime($request->input('begins_at')) < new DateTime($request->input('ends_at'));

        if (!$validDates){
            $errors = new MessageBag();
            $errors->add('Invalid dates', 'Begin date must be earlier than end date');
            return redirect(route('activities.edit', $activity->id))
                ->withErrors($errors)
                ->withInput();
        }

        $activity->begins_at = $request->input('begins_at');
        $activity->ends_at = $request->input('ends_at');
        $activity->description = $request->input('description');
        $activity->latitude = $request->input('latitude');
        $activity->longitude = $request->input('longitude');
        $activity->title = $request->input('title');
        $activity->category_id = $request->input('category_id');

        $activity->save();

        return redirect('/calendars');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Activity $activity)
    {
        if (Auth::user()->cannot('creator', $activity)) {
            return redirect()->back()->withErrors(['error' => 'You are not authorized to do this action']);
        }

        $activity->delete();

        return redirect('/calendars');
    }





    public function publish(Request $request, Activity $activity)
    {
        if (Auth::user()->cannot('owner', $activity)) {
            return redirect()->back()->withErrors(['error' => 'You are not authorized to do this action']);
        }

        
    }

}
