<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;


class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $orders = Order::orderBy('created_at', 'desc')->paginate(8);


        return view('dashboard.orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $companies = Company::all();

        return view('dashboard.orders.create', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'company_id' => 'required|exists:companies,id',
            'seller_name' => 'required|string',
            'location' => 'required|string',
            'customer_name' => 'required|string',
            'destination' => 'required|string',
            'customer_notes' => 'nullable|string',
            'attachment' => 'nullable|file|mimes:jpeg,png,pdf,docx|max:2048',

        ]);

        $data = $request->all();
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('attachments', $fileName, 'public');
            $data['attachment'] = $fileName;
        }

        $order = Order::create($data);

        // Validation passed, create the order

        Alert::success('Unique ID', $order->id);

        return redirect()->route('orders.index');
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
    public function edit(Order $order)
    {
        $companies = Company::all();
        return view('dashboard.orders.edit', compact('order', 'companies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {

        $request->validate([
            'company_id' => 'required|exists:companies,id',
            'seller_name' => 'required|string',
            'location' => 'required|string',
            'customer_name' => 'required|string',
            'destination' => 'required|string',
            'customer_notes' => 'nullable|string',
            'attachment' => 'nullable|file|mimes:jpeg,png,pdf,docx|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('attachment') && $request->file('attachment') !== null) {
            // If there is a new file, delete the old one (if it exists)
            if ($order->attachment) {
                Storage::disk('public')->delete('attachments/' . $order->attachment);
            }

            // Upload the new file
            $file = $request->file('attachment');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('attachments', $fileName, 'public');
            $data['attachment'] = $fileName;
        } else {
            // If no new file is uploaded, keep the existing file
            $data['attachment'] = $order->attachment;
        }

        $order->update($data);

        Alert::success('Order Updated Successfully');

        return redirect()->route('orders.index');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $order->delete();
        Alert::success('Success', "Order Deleted Successfully");

        return redirect()->route('orders.index');
    }
}
