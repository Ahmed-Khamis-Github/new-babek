<?php

namespace App\Http\Controllers\API\Authentication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse ;
use App\Http\Requests\UserLoginRequest;
use Illuminate\Support\Facades\Auth ;


class UserLogin extends Controller
{
    public function login(UserLoginRequest $request)
    {


        $credentials =['unique_id' => $request->unique_id, 'password' => $request->password] ;

        if (Auth::guard('web')->attempt($credentials)) {
            $user = Auth::guard('web')->user();
            // $user->tokens()->delete();
            $data['token'] = $user->createToken('UserLogin',['User'])->plainTextToken;
            $data['name'] =  $user->name;
            $data['email'] =  $user->email;
            $data['unique_id'] =  $user->unique_id;
            return ApiResponse::sendResponse(200, 'Login Successfully', $data);
        } else {
            return ApiResponse::sendResponse(401, 'Error with your credentials', null);
        }

         
    }
}
