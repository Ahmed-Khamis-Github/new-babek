<?php

namespace App\Http\Controllers\Frontend;

use App\Events\Payment;
use App\Http\Controllers\Controller;
 use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LockedController extends Controller
{
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
                        'unit_amount'  => $total,
                    ],
                    'quantity'   => 1,
                ],

            ],
            'mode'        => 'payment',
            'success_url' => route('locked.success'),
            'cancel_url'  => route('locked.checkout'),
        ]);

        return redirect()->away($session->url);
    }

    public function success(Request $request)
    {
        $totalAmount = Session::get('total_amount');

         $user = Auth::user();
          $user->status = 'active' ;
         $user->save();

 
         Session::forget('total_amount');

         return redirect()->route('dashboard') ;

      }
}
