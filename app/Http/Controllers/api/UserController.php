<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\logUserRequest;
use App\Http\Requests\userRegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function register(userRegisterRequest $request){
       try {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();
        return response()->json([
            "status_code"=>200,
            "status"=>"utilisateur enregistré avec success",
            "data"=>$user
        ]);
       } catch (\Throwable $th) {
        return response()->json($th);
       }
    }
    public function login(logUserRequest $request){
        try {
            if(Auth()->attempt($request->only(["email","password"]))){
                $user = Auth()->user();
                $token = $user->createToken("clee_token_backends")->plainTextToken;
                return response()->json(
                    [
                        "status_code"=>200,
                        "status"=>"utilisateur logger avec success",
                        "user"=> $user,
                        "token"=>$token
                    ]
                    );

            } else{
                return response()->json([
                    "status_code"=>401,
                    "status"=>"Erreur d'authentification",
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json($th);
        }
    }
}
