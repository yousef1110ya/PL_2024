<?php

use App\Http\Controllers\Auth\DriverAuthController;
use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\HomePage\StoreController;
use App\Http\Controllers\Order\CreatingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckDriver;
use App\Http\Middleware\CheckAdmin;



// for all users and admins

// creating the order from the user shopping cart
Route::post('/v0.1/orderPage/createOrder', [CreatingController::class, 'createOrder'])->middleware('auth:sanctum');
//dlete the order
Route::delete('/v0.1/UserOrder/{orderId}', [CreatingController::class, 'deleteOrder'])->middleware('auth:sanctum');
// edit the user location in the application
Route::put('/v0.1/UserOrder/editLocation', [UserAuthController::class, 'editLocation'])->middleware('auth:sanctum');
// edit the users shopping cart
Route::put('/v0.1/UserOrder/editCart', [UserAuthController::class, 'editShoppingCart'])->middleware('auth:sanctum');


// getting order by ID
Route::get('/orders/{orderId}', [CreatingController::class, 'getOrder'])->middleware('auth:sanctum');
// get all the orders for one user Past and present
Route::get('/v0.1/orders/history', [CreatingController::class, 'getAllMyOrders'])->middleware('auth:sanctum');




// for drivers
// getting all orders for the driver home page
Route::get('/orders', [CreatingController::class, 'getAllOrders'])->middleware(CheckDriver::class);
// to update the state of the order and then notify the user
Route::put('/orders/{orderId}/changeState', [CreatingController::class, 'updateOrderState'])->middleware(CheckDriver::class);
// accepting the order by the driver
Route::put('/orders/{orderId}/accept', [CreatingController::class, 'acceptOrder'])->middleware(CheckDriver::class)->middleware('auth:sanctum');
