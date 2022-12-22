<?php

namespace App\Http\Controllers\api;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegistrationRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Str;

use Illuminate\Database\Eloquent\Model;

class RegistrationController extends Controller
{
    public function registration(RegistrationRequest $request)
    {
       $request['remember_token'] = Str::random(10);
      
       $registration = User::create([
        'first_name' =>$request->first_name,
        'last_name' =>$request->last_name,
        'email' =>$request->email, 
        'password' =>\Hash::make($request->password),
        'remember_token' =>$request->remember_token  
                
        ]);

        $token = $registration->createToken('MyApp')->accessToken;

        return response()->json([
            'status' => true,
            'message' => "Registration has been Successfully Done!",            
            'token' =>$token

        ],201);
    }

    
}
