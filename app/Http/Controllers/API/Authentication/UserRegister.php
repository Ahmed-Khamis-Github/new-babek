<?php

namespace App\Http\Controllers\API\Authentication;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserRegister extends Controller
{
    public function register(UserRegisterRequest $request)
    {


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'unique_id' => $this->generateUniqueId(),
        ]);
        $data['token'] = $user->createToken('User')->plainTextToken;
        $data['unique_id'] = $user->unique_id;
        $data['email'] = $user->email;

        return ApiResponse::sendResponse(201, 'Account Created Successfully', $data);
    }



    public function generateUniqueId($length = 9)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $randomString;
    }
}
