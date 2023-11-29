<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class UserController extends Controller
{
    public function me(){
        return response()->json([
            'user' => Auth::user()
        ]);
    }

    public function update(Request $request)
    {
        $id = Auth::user()->id;
        $user = User::find($id);

        $validatedData = Validator::make($request->all(),
            [
                'number' => 'numeric|unique:users',
            ]
        );

        if($validatedData->fails()){
            return response()->json(["errors"=>$validatedData->errors()]);
        }

        if($request['number'] != null)
            $user->number = $request['number'];

        $user->save();

        return response()->json(['data' => $user]);
    }
}
