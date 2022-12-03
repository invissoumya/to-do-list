<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Validator;
use Auth;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function UserLogin(Request $request)
    {
        $input = $request->all();
        $validation = Validator::make($input, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if($validation->fails())
        {
            return response()->json(['error' =>$validation->errors()],422);
        }
        
            $data = [
                'email' => $request->email,  
                'password'   =>  $request->password        
            ];
          
          if(auth()->attempt($data)){
           
            $token = auth()->user()->createToken('Token')->accessToken;
            $user = auth()->user();

            $response = ['users' => $user,'token' => $token];
                return response($response, 200);
            
        } else {
            $response = ["message" =>'User does not exist'];
            return response($response, 401);
        }
    }

    public function logout (Request $request) {
        $token = $request->user()->token();
        $token->revoke();
        $response = ['message' => 'You have been successfully logged out!'];
        return response($response, 200);
    }

   
}
