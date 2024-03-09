<?php

use App\Http\Controllers\API\Authentication\CompanyLogin;
use App\Http\Controllers\API\Authentication\CompanyRegister;
use App\Http\Controllers\API\Authentication\Logout;
use App\Http\Controllers\API\Authentication\UserLogin;
use App\Http\Controllers\API\Authentication\UserRegister;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Dashboard\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});





// user auth 

Route::post('user-register', [UserRegister::class, 'register']);

Route::post('user-login', [UserLogin::class, 'login']);


// company auth 

Route::post('company-register', [CompanyRegister::class, 'register']);

Route::post('company-login', [CompanyLogin::class, 'login']);


// show orders 
Route::get('/orders', [OrderController::class, 'index']);

// user accept order 

Route::patch('/orders/{order}/accept', [OrderController::class, 'acceptOrder'])->middleware('auth:sanctum');

// count completed orders
Route::get('/user/delivered-orders-count', [OrderController::class, 'getDeliveredOrdersCount']);

// show completed orders 
Route::get('/user/delivered-orders', [OrderController::class, 'getDeliveredOrders']);


//show pending orders 

Route::get('/user/filtered-orders', [OrderController::class, 'getFilteredOrders']);



// order info 
// show order info 
Route::get('/user/orders/{orderId}', [OrderController::class, 'getOrderInfo']);


// show orders for company
Route::get('/company/all-orders-for-company', [OrderController::class, 'getAllOrdersForCompany']);


//search by order id
Route::get('/company/search', [OrderController::class, 'search']);




Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [Logout::class, 'logout']);
});