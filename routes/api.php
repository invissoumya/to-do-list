<?php

use App\Http\Controllers\api\RegistrationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api;
use App\Http\Controllers\api\LoginController;
use App\Http\Controllers\api\TodoController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login',[LoginController::class,'UserLogin']);
Route::post('registrations',[RegistrationController::class,'registration']);

Route::middleware('auth:api')->group(function(){
    //Route::apiResource('todos',ToDosController::class);
    Route::get('todos',[TodoController::class,'index']);
    Route::post('todos',[TodoController::class,'create']);
    Route::put('todos/{id}',[TodoController::class,'update']);
    Route::delete('todos/{id}',[TodoController::class,'delete']);

});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});