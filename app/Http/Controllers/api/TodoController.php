<?php
namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TodoRequest;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Todos;

use Validator;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{
    public function index()
    {
        $todos = auth()->user()->todos()->get();
        return response()->json([
            'status' =>true,
            'todos' => $todos,
            'user' => auth()->user()

        ]);
    }

    public function create(TodoRequest $request)
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

    public function update(TodoRequest $request,$id, Todos $todos)
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

    public function delete(Request $request,$id,Todos $todos)
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
