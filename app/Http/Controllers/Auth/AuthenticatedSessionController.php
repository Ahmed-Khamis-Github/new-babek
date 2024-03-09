<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    public function createAdmin(): View
    {
        return view('auth.loginAdmin');
    }


    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();
        $url = '';
        if ($request->user()->role ==='super') {
            $url = 'super/dashboard';
        } elseif ($request->user()->role === 'user') {
            $url = '/dashboard';
        }
        return redirect()->intended($url);
    }

    public function storeAdmin(LoginRequest $request)
    {
        $user = User::where('email', $request->email)
        ->whereIn('role', ["admin", "super"])
        ->first();


        if(! $user){
            return redirect()->route('admin.login')->with("message" ,"wrong email or password !");
        }

        $request->authenticate() ;
        $request->session()->regenerate() ;
        return redirect()->route('admin.home') ;


    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
