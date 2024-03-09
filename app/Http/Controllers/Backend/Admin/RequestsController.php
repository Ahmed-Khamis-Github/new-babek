<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Form;

class RequestsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $requests=  Form::all() ;

        return view('backend.pages.requests.index',compact('requests')) ;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
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
    public function edit(string $id)
    {

        $form =Form::findOrFail($id)  ;

        return view('backend.pages.requests.create',compact('form')) ;

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $form =Form::findOrFail($id)  ;

         $form->update([
            'price'=>$request->price
        ]) ;

        return redirect()->route('requests.index') ;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
