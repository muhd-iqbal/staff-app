<?php

use App\Models\Customer;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('customer/{customer}', function ($customer) {
    return [
        'order' => Order::with(['order_item'])->where('customer_id', $customer)->where('date', '>=', env('POS_START'))->orderBy('id', 'DESC')->paginate(20),
        'customer' => Customer::find($customer),
    ];
});
