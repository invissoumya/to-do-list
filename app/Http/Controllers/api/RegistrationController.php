<?php

namespace App\Http\Controllers\api;

use App\Http\Requests\StoreRegistrationRequest;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;
use Str;
use Illuminate\Database\Eloquent\Model;

class RegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $registrations = User::all();
        return response()->json([
            'status' =>true,
            'registrations' => $registrations

        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRegistrationRequest $request)
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
            'registration' =>$registration,
            'token' =>$token

        ],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Registration  $registration
     * @return \Illuminate\Http\Response
     */
    public function show(User $registration)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Registration  $registration
     * @return \Illuminate\Http\Response
     */
    public function edit(Registration $registration)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Registration  $registration
     * @return \Illuminate\Http\Response
     */
    public function update(StoreRegistrationRequest $request, User $registration)
    {
        $registration->update($request->all());
        return response()->json([
            'status' => true,
            'message' => "Registration has been Updated Successfully!",
            'registration' =>$registration,

       ],200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Registration  $registration
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $registration)
    {
        $registration->delete();
        return response()->json([
            'status' => true,
            'message' => "Registration has been Successfully Deleted!",
            'registration' =>$registration,

       ],200);
    }
}
