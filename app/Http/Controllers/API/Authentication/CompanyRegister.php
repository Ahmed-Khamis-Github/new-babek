<?php

namespace App\Http\Controllers\API\Authentication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Http\Requests\CompanyRegisterRequest;
use Illuminate\Support\Facades\Hash;
use App\Helpers\ApiResponse;


class CompanyRegister extends Controller
{
    public function register(CompanyRegisterRequest $request)
    {
        $company = Company::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'unique_id' => $this->generateUniqueId(),

        ]);
        $data['token'] = $company->createToken('Company')->plainTextToken;
        $data['name'] = $company->name;
        $data['unique_id'] = $company->unique_id;
        $data['email'] = $company->email;

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
