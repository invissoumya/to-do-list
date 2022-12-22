<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Todos;
use Illuminate\Http\Request;

use Validator;
use Illuminate\Support\Facades\Auth;

class ToDosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::find(auth()->user()->id);
        if($user)
        {
            $todos = $user->todos()->get();
            return response()->json([
                'status' =>true,
                'todos' => $todos,
                'user' => auth()->user()

            ]);
        }
   
        else
        {
            return response()->json([
                'status' => true,
                'message' => "Action not possible",
            

            ],422);
        }
    
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
    public function store(Request $request)
    {       
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',        
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        else
        {
       
            $todos = Todos::create([
                'title' =>$request->title,
                'user_id' =>auth()->user()->id                     
            ]);

            return response()->json([
                'status' => true,
                'message' => "To Do entry has been Successfully Created!",
                'todos' =>$todos,
                'user' =>auth()->user()
                

            ],201);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Todos  $todos
     * @return \Illuminate\Http\Response
     */
    public function show(Todos $todos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Todos  $todos
     * @return \Illuminate\Http\Response
     */
    public function edit(Todos $todos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Todos  $todos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id, Todos $todos)
    {
        $request['id'] = $id;
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',  
            'id'    =>'required|numeric|gt:0'
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        else
        {
            $user = User::find(auth()->user()->id);               
            $todos_update = $user->todos()->where('id',$id)->update(['title' => $request->title ]);           
            $todos_updated = $todos->find($id);
            if($todos_update)
            {
                return response()->json([
                    'status' => true,
                    'message' => "To Do has been Updated Successfully!",
                    'todos' =>$todos_updated,
                    'user' =>$user

                ],200);
            }
            else
            {
                return response()->json([
                    'status' => true,
                    'message' => "Action not possible",
                

                ],422);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Todos  $todos
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id,Todos $todos)
    {
        $request['id'] = $id;
        $validator = Validator::make($request->all(), [
           'id'    =>'required|numeric|gt:0'
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        else
        {

            $todos_delete = Todos::Where('user_id', auth()->user()->id)->where('id',$id)->delete();
            if($todos_delete)
            {
                return response()->json([
                        'status' => true,
                        'message' => "To do has been Successfully Deleted!",
                    

                ],200);
            }
            else
            {
                return response()->json([
                    'status' => true,
                    'message' => "Action not possible",
                

            ],422);
            }
        }
    }
}
