<?php

namespace App\Http\Controllers\API\Authentication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ApiResponse;
use App\Http\Requests\CompanyLoginRequest;

class CompanyLogin extends Controller
{

    public function login(CompanyLoginRequest $request)
    {
        $credentials = ['unique_id' => $request->unique_id, 'password' => $request->password];

        if (Auth::guard('company')->attempt($credentials)) {
            $user = Auth::guard('company')->user();
            // $user->tokens()->delete();

            $data['token'] = $user->createToken('companyLogin', ['company'])->plainTextToken;
            $data['company_name'] = $user->name;
            $data['email'] = $user->email;
            $data['unique_id'] = $user->unique_id;
            return ApiResponse::sendResponse(200, 'Login Successfully', $data);
        } else {
            return ApiResponse::sendResponse(401, 'Error with your credentials', null);
        }
    }
}
