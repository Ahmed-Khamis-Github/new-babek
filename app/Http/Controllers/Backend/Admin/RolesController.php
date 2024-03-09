<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RolesRequest;
use App\Models\Role;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::paginate(8) ;
        return view('backend.pages.roles.index',compact('roles')) ;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $role=new Role() ;
        return view('backend.pages.roles.create',compact('role')) ;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $role=Role::createWithAbilities($request) ;
        return redirect()->route('dashboard.roles.index')->with('success','Role Created Successfully') ;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        $role_abilities=$role->abilities()->pluck('type','ability')->toArray() ;
        // dd($role_abilities) ;
        // dd($role_abilities) ;
        return view('backend.pages.roles.edit',compact('role','role_abilities')) ;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RolesRequest $request, Role $role)
    {
        $role->updateWithAbilities($request) ;

        return redirect()->route('dashboard.roles.index')->with('success','Role Updated Successfully') ;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Role::destroy($id);
        return redirect()
            ->route('dashboard.roles.index')
            ->with('success', 'Role deleted successfully');
    }
}
