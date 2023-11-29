<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Visiting;
use App\Mail\MailNotify;
use Mail;

class VisitingController extends Controller
{
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'supervisor_name' => 'required|string',
            'school_name' => 'required|string',
            'date' => 'required|date_format:Y-m-d',
            'form' => 'required|mimes:pdf',
        ]);
    }

    public function addVisiting(Request $request)
    {
        $validatedData = $this->validator($request->all());
        if ($validatedData->fails())  {
            return response()->json(['errors'=>$validatedData->errors()], 400);
        }

        $visiting = new Visiting;

        $visiting->supervisor_name = $request['supervisor_name'];
        $visiting->school_name = $request['school_name'];
        $visiting->date = $request['date'];

        if ($request->hasFile('form')) {

            // Get filename with extension
            $filenameWithExt = $request->file('form')->getClientOriginalName();

            // Get just the filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);

            // Get extension
            $extension = $request->file('form')->getClientOriginalExtension();

            // Create new filename
            $filenameToStore = $filename.'_'.time().'.'.$extension;

            // Uplaod Form
            $path = $request->file('form')->storeAs('public/forms/', $filenameToStore);

            $visiting->form = $filenameToStore;

        }

        $visiting->save();

        $mailData = [
            'type' => 'زيارة',
            'supervisor_name' => $request['supervisor_name'],
        ];

        // tseen1791@moe.gov.sa

        Mail::to('mohammadalkhatab123@gmail.com')->send(new MailNotify($mailData));

        return response()->json(['data' => $visiting], 200);
    }

    public function getVisitings()
    {
        $visitings = Visiting::orderBy('date', 'DESC')->get();

        return response()->json($visitings, 200);
    }

    public function searchVisitings($query)
    {
        $visitings = Visiting::where('supervisor_name', 'LIKE', '%' . $query . '%')
                                ->orderBy('date', 'DESC')->get();

        return response()->json($visitings, 200);
    }

    public function deleteVisiting($id)
    {
        $visiting = Visiting::find($id);

        if(!$visiting){
            return response()->json(['errors' => 'There is no visiting with this id !'], 400);
        }

        $visiting->delete();
        
        return response()->json(['message' => "Visiting Deleted"], 200);
    }
}
