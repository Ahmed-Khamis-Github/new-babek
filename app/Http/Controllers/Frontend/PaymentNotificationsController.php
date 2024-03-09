<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentNotificationsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function markAsRead(Request $request)
    {
        // Assuming you have a 'notifications' table with a 'read' column
        // Update the 'read' column for all notifications related to the authenticated user

        auth()->user()->notifications()->update(['read_at' => now()]);

        return response()->json(['message' => 'Notifications marked as read']);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
