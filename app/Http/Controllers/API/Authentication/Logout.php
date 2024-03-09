<?php

namespace App\Http\Controllers\API\Authentication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Logout extends Controller
{


    public function logout()
{
    $user = Auth::user();

    // Revoke the user's token
    $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();

    return response()->json(['message' => 'Logged out successfully']);
}

}
