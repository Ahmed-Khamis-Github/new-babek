<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Country;
use App\Models\Dashboard\CompanyFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PendingController extends Controller
{
    public function index()
{
    $companies = Company::whereHas('user', function ($query) {
        $query->where(function ($subQuery) {
            $subQuery->where('status', 'pending')
                      ->orWhere('status', 'inactive');
        })->where('role', '!=', 'admin'); // Exclude admin users
    })->with(['user' => function ($query) {
        $query->where(function ($subQuery) {
            $subQuery->where('status', 'pending')
                      ->orWhere('status', 'inactive');
        })->where('role', '!=', 'super_admin'); // Exclude admin users
    }], 'country')->orderBy('created_at', 'desc')->get();

    return view('backend.pages.pendings.index', compact('companies'));
}


    public function show($id)
    {

        $company = Company::findOrFail($id);
        $data = json_decode($company->company_data, true);
        $files = CompanyFile::where('company_id', $id)->orderBy('created_at', 'desc')->get();
        return view('backend.pages.pendings.show', compact('company', 'data', 'files'));
    }

    public function edit(string $id)
    {
        $company= Company::findOrFail($id) ;
 
          return view ('backend.pages.pendings.edit',compact('company')) ;
    }


    public function update(Request $request, string $id)
    {

        $company = Company::findOrFail($id) ;
        $company->update([
            'registration_price' => $request->registration_price
            
         ]) ;

         return redirect()->route('index.pending') ;

    }


    public function session(Request $request)
    {
        \Stripe\Stripe::setApiKey(config('stripe.sk'));

         $totalprice = $request->get('total');

         $total = "$totalprice";
        Session::put('total_amount', $total);

        $session = \Stripe\Checkout\Session::create([
            'line_items'  => [
                [
                    'price_data' => [
                        'currency'     => 'USD',
                        'product_data' => [
                            "name" => 'Registeration Payment',
                        ],
                        'unit_amount'  => $total*100,
                    ],
                    'quantity'   => 1,
                ],

            ],
            'mode'        => 'payment',
            'success_url' => route('pending.success'),
            'cancel_url'  => route('locked.checkout'),
        ]);

        return redirect()->away($session->url);
    }

    public function success(Request $request)
    {
        $totalAmount = Session::get('total_amount');
    
        $user = Auth::user();
        $user->companies->first()->update(['paid' => 1]); // set the company paid === 1
        $user->status = 'inactive';
        $user->save();
    
        Session::forget('total_amount');
    
        return redirect('/pending');
    }


    public function markAsCompleted(Company $company)
{
    $company->update(['completed' => true]);

    return redirect()->back()->with('success', 'Company marked as completed successfully!');
}
}
