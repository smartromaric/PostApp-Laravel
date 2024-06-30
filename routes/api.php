<?php

use App\Http\Controllers\api\PostController as ApiPostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route :: get("test",function(){
    return "test";
});
Route::post("register/",[UserController::class,"register"]);
Route::post("login",[UserController::class,"login"]);
Route::middleware('auth:sanctum')->group(function (){
    
    Route::get("user",function(Request $request){
        return $request->user();
    });
    Route::get("posts",[ApiPostController::class,'index']);
    Route::post("posts/create",[ApiPostController::class,"store"]);
    Route::put("posts/edite/{post}",[ApiPostController::class,"update"]);
    Route::delete("posts/{post}",[ApiPostController::class,"delete"]);
});
