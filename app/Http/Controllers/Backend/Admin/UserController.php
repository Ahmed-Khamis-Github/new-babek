<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('users.view');

        $request = request();

        $users =User::where('role','user')->search($request->query())->paginate(15) ;

        return view('backend.pages.users.index',compact('users')) ;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('users.create');

         return view('backend.pages.users.create') ;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {

        $data = $request->all() ;
 
        $dialCode = $data['dial_code'];

        // Concatenate the dial code and mobile number
        $fullMobileNumber = $dialCode . $data['phone'];


        $user= User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone'=> $fullMobileNumber  ,
            'address'=>$request->address
        ]);
       



         return redirect()->route('users.index')->with('success','User Added Successfully') ;
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('backend.pages.users.show',compact('user')) ;

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        Gate::authorize('users.update');


        return view('backend.pages.users.edit',compact('user')) ;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user)
    {

        $data = $request->all() ;

        if( empty( $data['password'] ) && empty( $data['password_confirmation'] )  ){
            unset($data['password']);
            unset($data['password_confirmation']);
        }

        $user->update([

            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone'=>$request->phone ,
            'address'=>$request->address
        ]) ;


        return redirect()->route('users.index')->with('success','User Updated Successfully') ;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        Gate::authorize('users.delete');


        $user->delete() ;
        return redirect()->route('users.index')->with('success','User Deleted Successfully') ;
    }
}
