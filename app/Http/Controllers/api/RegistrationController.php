<?php
namespace App\Http\Controllers\api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Str;
use Validator;

use Illuminate\Database\Eloquent\Model;

class RegistrationController extends Controller
{
    public function registration(Request $request)
    {
        $request['remember_token'] = Str::random(10); 
        $input = $request->all();
        
        $validation = Validator::make($input, [
            'first_name' => "required|max:100",
            'last_name' => "required|max:100",
            'email' => "required|max:100|email|unique:users",
            'password' => "required|min:8|max:25|confirmed",
        ]);

        if($validation->fails())
        {
            return response()->json(['error' =>$validation->errors()],422);
        }          

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
