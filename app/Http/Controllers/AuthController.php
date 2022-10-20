<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\Models\User;
use App\Http\Requests\RegiserRequest;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function Login(Request $request){

        try{
            if (Auth::attempt($request->only('email', 'password'))){
                $user = Auth::user();
                $token = $user->createToken('app')->accessToken;

                return response([
                    'message' => "Succesfully Login",
                    'token'=> $token,
                    'user' =>  $user
                ], 200); //Status cose
            }
        }catch(Exception $exception){
            return response([
                'message' => $exception->getMessage()
            ], 400);
        }
        return response([
            'message' => 'Invalid Email or Password'
        ],401);
    //End Method
    }


    public function Register(RegiserRequest $request){
      try{
        $user = User::create([
            'name'=> $request->name,
            'email'=> $request->email,
            'password'=>Hash::make($request->password)
        ]);
        $token = $user->createToken('app')->accessToken;
        // $token = $request->user()->createToken($request->token_name);
        return response([
            'message' => "Registration successfully",
            'token'=> $token,
            'user' =>  $user
        ], 200); //Status cose
      }catch(Exception $exception){
        return response([
            'message' => $exception->getMessage()
        ], 400);
    }

    } //End method Register
}