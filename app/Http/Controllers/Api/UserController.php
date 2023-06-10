<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUser;
use App\Http\Requests\User\EditUserRequest;
use App\Models\User;

class UserController extends Controller
{

    public function register(RegisterUser $request )
    {
        try {

            $User = new User();
            $User->name = $request->name;
            $User->email = $request->email;
            $User->password = $request->password;
            $User->save();
            return response()->json([
                "status_code"=>200,
                "status_messaqe"=>"utilisateur cree",
                "data"=>$User,
            ]);
        }
        catch (\Exception $e){
            return response()->json($e);
        }
    }
//    public function register(RegisterUser $request)
//    {
//        try {
//            $user = new User();
//            $user->name = $request->name;
//            $user->email = $request->email;
//            $user->password = $request->password;
//
//            $user->save();
//            return response()->json([
//                "status_code"=>200,
//                "status_message"=>" L'utilisateur est créé",
//                "data"=>$user
//            ]);
//        }catch (\Exception $e){
//            return response()->json($e);
//        }
//
//
//
//    }
    public function update(EditUserRequest $request,User $user)
    {
        if ($user){
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = $request->password;
            $user->save();
            return response()->json([
                "status_code"=>200,
                "status_messaqe"=>"utilisateur modifie",
                "data"=>$user,
            ]);
        }
        else
        {
            return response()->json([
                "status_code"=>404,
                "status_messaqe"=>"utilisateur non trouve",

            ]);
        }

    }

    public function login(LoginUserRequest $request, User $user)
    {
            if(auth()->attempt($request->only(['email','password']))){
                $user = auth()->user();
                $token = $user->createToken(env('TOKEN_APP'))->plainTextToken;
                return response()->json([
                    "status_code"=>200,
                    "status_message"=>" L'utilisateur est connecté",
                    "user"=>$user,
                    "token"=>$token,
                ]);
            }else{
                return response()->json([
                    "status_code"=>403,
                    "status_message"=>"Informations non valides",
                ]);
            }





    }
}
