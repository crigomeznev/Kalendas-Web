<?php

namespace App\Http\Controllers;

use App\Models\Target;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;

class TargetController extends Controller
{
    public function index()
    {
        return redirect('/calendars');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::user()->cannot('ownerImplicit')) {
            return redirect()->back()->withErrors(['error' => 'You are not authorized to do this action']);
        }

        $fields = [
            'name' => $request->input('target_name'),
            'email' => $request->input('target_email'),
            'calendar_id' => session('calendar')->id,
        ];

        $validator = Validator::make($fields, [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:targets',
            'calendar_id' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('/calendars')
                ->withErrors($validator)
                ->withInput();
        }

        Target::create($fields);
        return redirect('/calendars');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Target $target)
    {
        if (Auth::user()->cannot('owner', $calendar)) {
            return redirect()->back()->withErrors(['error' => 'You are not authorized to do this action']);
        }

        return redirect('/calendars');
    }


    // Custom
    /**
     * Uploads a csv file including targets to be created or updated
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request)
    {
        $this->authorize('ownerImplicit');

        try {
            $file = $request->file('target_file');
            if (!$file) {
                //no file was uploaded
                throw new \Exception('No file was uploaded', Response::HTTP_BAD_REQUEST);
            }

            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension(); //Get extension of uploaded file
            $tempPath = $file->getRealPath();
            $fileSize = $file->getSize(); //Get size of uploaded file in bytes

            //Check for file extension and size
            $this->checkUploadedFileProperties($extension, $fileSize);

            // TODO: CONFIG FILE!
            //Where uploaded file will be stored on the server 
            $location = 'temp'; //Created an "uploads" folder for that
            // Upload file
            $file->move($location, $filename);
            // In case the uploaded file path is to be stored in the database 
            $filepath = public_path($location . "/" . $filename);

            // Reading file
            $file = fopen($filepath, "r");
            $targets_arr = array();
            $i = 0;
            //Read the contents of the uploaded file
            while (($filedata = fgetcsv($file, 1000, ";")) !== FALSE) {
                // Skip first row (Remove below comment if you want to skip the first row)
                if ($i == 0) {
                    $i++;
                    continue;
                }

                array_push($targets_arr, array(
                    'name' => $filedata[0],
                    'email' => $filedata[1],
                ));
                $i++;
            }
            fclose($file); //Close after reading

            foreach ($targets_arr as $entry) {
                // Validate
                $validator = Validator::make($entry, [
                    'name' => 'required|min:3',
                    'email' => 'required|email'
                ]);
                if ($validator->fails()) {
                    throw new \Exception($validator->errors()->first());
                }

                $target = Target::firstWhere('email', $entry['email']);

                if (is_null($target)) {
                    // If target not exists, create it
                    Target::create([
                        'name' => $entry['name'],
                        'email' => $entry['email'],
                        'calendar_id' => session('calendar')->id
                    ]);
                } else {
                    // If it already exists, update it (only name can be updated)
                    $target->name = $entry['name'];
                    $target->save();
                }
            }
        } catch (\Exception $ex) {
            $messageBag = new MessageBag(['error' => $ex->getMessage()]);
            return redirect('/calendars')
                ->withErrors($messageBag)
                ->withInput();
        }
        return redirect('/calendars');
    }



    protected function checkUploadedFileProperties($extension, $fileSize)
    {
        $valid_extension = array("csv", "xlsx"); //Only want csv and excel files
        // TODO: CONFIG FILE
        $maxFileSize = 2097152; // Uploaded file size limit is 2mb
        if (!in_array(strtolower($extension), $valid_extension)) {
            throw new \Exception('Invalid file extension', Response::HTTP_UNSUPPORTED_MEDIA_TYPE); //415 error
        }

        if ($fileSize > $maxFileSize) {
            throw new \Exception('File size has to be less than 2mb', Response::HTTP_REQUEST_ENTITY_TOO_LARGE); //413 error
        }
    }
}
