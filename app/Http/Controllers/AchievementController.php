<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Achievement;
use App\Mail\MailNotify;
use Mail;

class AchievementController extends Controller
{
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'supervisor_name' => 'required|string',
            'achievement_name' => 'required|string',
            'day' => 'required|string',
            'date' => 'required|date_format:Y-m-d',
            'semester' => 'required|string',
            'section' => 'required|string',
            'section_type' => 'required|string',
            'proof' => 'required|string',
            'attendees_number' => 'required|numeric',
            'target_group' => 'required|string',
        ]);
    }

    public function addAchievement(Request $request)
    {
        $validatedData = $this->validator($request->all());
        if ($validatedData->fails())  {
            return response()->json(['errors'=>$validatedData->errors()], 400);
        }

        $achievement = new Achievement;

        $achievement->supervisor_name = $request['supervisor_name'];
        $achievement->achievement_name = $request['achievement_name'];
        $achievement->day = $request['day'];
        $achievement->date = $request['date'];
        $achievement->semester = $request['semester'];
        $achievement->section = $request['section'];
        $achievement->section_type = $request['section_type'];
        $achievement->proof = $request['proof'];
        $achievement->attendees_number = $request['attendees_number'];
        $achievement->target_group = $request['target_group'];

        $achievement->save();

        $mailData = [
            'type' => 'منجز',
            'supervisor_name' => $request['supervisor_name'],
        ];

        Mail::to('mohammadalkhatab123@gmail.com')->send(new MailNotify($mailData));

        return response()->json(['data' => $achievement], 200);
    }

    public function getAchievements()
    {
        $achievements = Achievement::orderBy('date', 'DESC')->get();

        return response()->json($achievements, 200);
    }

    public function searchAchievements($query)
    {
        $achievements = Achievement::where('supervisor_name', 'LIKE', '%' . $query . '%')
                                    ->orderBy('date', 'DESC')->get();

        return response()->json($achievements, 200);
    }

    public function deleteAchievement($id)
    {
        $achievement = Achievement::find($id);

        if(!$achievement){
            return response()->json(['errors' => 'There is no achievement with this id !'], 400);
        }

        $achievement->delete();
        
        return response()->json(['message' => "Achievement Deleted"], 200);
    }
}
