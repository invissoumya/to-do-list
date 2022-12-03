<?php

use App\Http\Controllers\api\RegistrationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api;
use App\Http\Controllers\api\LoginController;
use App\Http\Controllers\api\ToDosController;

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



Route::apiResource('registrations',RegistrationController::class);

Route::post('login',[LoginController::class,'UserLogin']);



Route::middleware('auth:api')->group(function(){
    Route::apiResource('todos',ToDosController::class);

});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});