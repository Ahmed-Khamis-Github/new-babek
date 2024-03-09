<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderUser;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;


class OrderUserController extends Controller
{

    public function showOrdersWithOffers()
    {
        // Get orders that have offers
        $ordersWithOffers = Order::has('users')->orderBy('created_at', 'desc')->paginate(8);



        // dd($ordersWithOffers);
        return view('dashboard.offers.orders_with_offers', compact('ordersWithOffers'));
    }




    public function showOffersForOrder($orderId)
    {
        $order = Order::with('users')->findOrFail($orderId);


        $chosenUserCount = 0;

        foreach ($order->users as $user) {
            if ($user->pivot->chosen) {
                $chosenUserCount++;
            }
        }

        // Get all offers for the order
        $offers = $order->users;


        return view('dashboard.offers.show_offers', compact('order', 'offers', 'chosenUserCount'));
    }

    public function acceptOffer(Request $request, $offerId)
    {

        // Find the OrderUser record
        $orderUser = OrderUser::where('order_id', $request->order_id)->where('user_id', $offerId)->first();

        // Update the chosen column
        $orderUser->update(['chosen' => true]);

        // Update the associated order's status to "Accepted"
        $order = $request->order_id;
        $order = Order::findOrFail($order);
        $order->update(['order_status' => 'Accepted']);

        // Redirect back or to a specific route
        Alert::success('Accepted', "User Accepted Succussfully");

        return redirect()->route('offers.show_orders_with_offers');
    }
}
