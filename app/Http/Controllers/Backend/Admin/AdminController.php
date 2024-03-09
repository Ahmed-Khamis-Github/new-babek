<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Gate::authorize('admins.view');

        $request = request();

        $admins =User::where('role','admin')->search($request->query())->paginate(8) ;

        return view('backend.pages.admins.index',compact('admins')) ;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Gate::authorize('users.create');

        $roles = Role::all() ;
        return view('backend.pages.admins.create',compact('roles')) ;

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $data = $request->all() ;
 
        $dialCode = $data['dial_code'];

        // Concatenate the dial code and mobile number
        $fullMobileNumber = $dialCode . $data['phone'];

         $user= User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $fullMobileNumber,
            'address' => $request->address,
            'password' => Hash::make($request->password),

            'role'=>'admin'
         ]);

        $user->roles()->attach($request->roles)  ;



         return redirect()->route('admins.index')->with('success','User Added Successfully') ;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user  = User::findOrFail($id) ;
        return view('backend.pages.admins.show',compact('user')) ;

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        Gate::authorize('users.update');

        $user = User::findOrFail($id) ;

        $roles = Role::all();
        $user_roles = $user->roles()->pluck('id')->first();
        // dd($user_roles) ;

         return view('backend.pages.admins.edit',compact('user','user_roles','roles')) ;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $user = User::findOrFail($id) ;
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
        $user->roles()->sync($request->roles);



        return redirect()->route('admins.index')->with('success','User Updated Successfully') ;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        Gate::authorize('users.delete');

        $user= User::FindOrFail($id) ;

        $user->delete() ;
        return redirect()->route('admins.index')->with('success','Admin Deleted Successfully') ;
    }
}
