<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'number' => 'required|numeric|unique:users',
            'password' => 'required|string|min:7',
            'confirm_password' => 'required|same:password',
        ]);
    }

    public function register(Request $request)
    {

        $validatedData = $this->validator($request->all());
        if ($validatedData->fails())  {
            return response()->json(['errors'=>$validatedData->errors()]);
        }

        $user = User::create([
            'number' => $request['number'],
            'password' => Hash::make($request['password']),
        ]);

        $user->save();

        $token = $user->createToken('Laravel Password Grant Client')->accessToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function login(Request $request)
    {
        if(Auth::attempt($request->only('number', 'password'))){

            $user = User::where('number', $request['number'])->firstOrFail();

        }else{
            return response()->json([
                'message' => 'Invalid login details'
            ], 401);
        }

        $token = $user->createToken('Laravel Password Grant Client')->accessToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function changePassword(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(),[
            'new_password' => 'required|string|min:7',
            'confirm_new_password' => 'required|same:new_password',
        ]);

        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors()]);
        }


        $user->password = Hash::make($request['new_password']);
        $user->save();

        return response()->json(['data' => 'change password done'],403);
    }

    public function logout (Request $request) {
        $token = $request->user()->token();
        $token->revoke();
        $response = ['message' => 'You have been successfully logged out!'];
        return response()->json($response, 200);
    }
}
