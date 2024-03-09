<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use App\Http\Resources\OrderResource;
use App\Models\OrderUser;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }


    public function index()
    {

        $orders = Order::all();

        return ApiResponse::sendResponse(200, 'Orders Retrieved Successfully', OrderResource::collection($orders));
    }


    public function acceptOrder(Order $order)
    {
        $user = auth()->user();

        // Check if the user has already accepted the order
        if ($order->users()->where('user_id', $user->id)->exists()) {
            return ApiResponse::sendResponse(400, 'تمت الموافقة مسبقا علي هذا الاوردر');
        }

        // Attach the user to the order (accept the order)
        $orderUser = OrderUser::create([
            'user_id' => $user->id,
            'order_id' => $order->id,
            'chosen' => false,
        ]);



        return ApiResponse::sendResponse(200, 'تمت الموافقة علي الاوردر');
    }



    public function getDeliveredOrdersCount()
    {
        $user = auth()->user();
        $deliveredOrdersCount = $user->orders()->where('order_status', 'Delivered')->count();

        $excludedStatuses = ['Pending', 'Delivered'];

        // Count orders with a status other than the excluded ones
        $pendingOrdersCount = $user->orders()->whereNotIn('order_status', $excludedStatuses)->count();


        $data['deliveredOrdersCount'] =  $deliveredOrdersCount;
        $data['pendingOrdersCount'] =  $pendingOrdersCount;

        return ApiResponse::sendResponse(200, 'Count Retrieved Successfully', $data);
    }


    public function getDeliveredOrders()
    {
        $user = auth()->user();
        $deliveredOrders = $user->orders()->where('order_status', 'Delivered')->get();


        return ApiResponse::sendResponse(200, 'Completed Retrieved Successfully', $deliveredOrders);
    }


    public function getFilteredOrders()
    {
        $user = auth()->user();

        // Specify the statuses to exclude (e.g., 'Pending' and 'Delivered')
        $excludedStatuses = ['Pending', 'Delivered'];

        // Retrieve orders with a status other than the excluded ones
        $filteredOrders = $user->orders()->whereNotIn('order_status', $excludedStatuses)->get();


        return ApiResponse::sendResponse(200, 'Pending Order Retrieved Successfully', $filteredOrders);
    }


    // public function getFilteredOrdersCount()
    // {
    //     $user = auth()->user();

    //     // Specify the statuses to exclude (e.g., 'Pending' and 'Delivered')
    //     $excludedStatuses = ['Pending', 'Delivered'];

    //     // Count orders with a status other than the excluded ones
    //     $filteredOrdersCount = $user->orders()->whereNotIn('order_status', $excludedStatuses)->count();

    //     return response()->json(['filtered_orders_count' => $filteredOrdersCount]);
    // }


    public function getOrderInfo($orderId)
    {
        // Ensure the order belongs to the authenticated user
        $user = auth()->user();

        // Use findOrFail to get the order by ID or return 404 if not found
        $order = $user->orders()->findOrFail($orderId);

        return new OrderResource($order);
    }

    public function getAllOrdersForCompany()
    {
        $companyId = auth()->user()->id; // Assuming the company_id is stored in the 'id' field of the company table
        $orders = Order::where('company_id', $companyId)->get();

 
        return ApiResponse::sendResponse(200, 'Orders Retrieved Successfully', OrderResource::collection($orders));

    }


    //search for order
    public function search(Request $request)
    {
        $companyId = auth()->user()->id; // Assuming the company_id is stored in the 'id' field of the company table

        $query = Order::where('company_id', $companyId);

        // Search by order ID if the 'search' parameter is provided in the request
        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where('id', $searchTerm);
        }

        $orders = $query->get();

 
        return ApiResponse::sendResponse(200, 'Order Retrieved Successfully', OrderResource::collection($orders));

    }
}
