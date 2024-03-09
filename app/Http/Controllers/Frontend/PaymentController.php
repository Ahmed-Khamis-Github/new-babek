<?php

namespace App\Http\Controllers\Frontend;

use App\Events\Payment;
use App\Http\Controllers\Controller;
use App\Notifications\PaymentNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PaymentController extends Controller
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
            'success_url' => route('success'),
            'cancel_url'  => route('checkout'),
        ]);

        return redirect()->away($session->url);
    }

    public function success(Request $request)
    {
        $totalAmount = Session::get('total_amount');

         $user = Auth::user();
 

         $user->wallet +=$totalAmount/100 ;
         $user->save();

         $user->notify(new PaymentNotification($user,$totalAmount));

         Session::forget('total_amount');

         return redirect()->route('dashboard') ;

      }
}
