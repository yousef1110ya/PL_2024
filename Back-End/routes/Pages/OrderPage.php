<?php

use App\Http\Controllers\Auth\DriverAuthController;
use App\Http\Controllers\HomePage\StoreController;
use App\Http\Controllers\Order\CreatingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckDriver;
use App\Http\Middleware\CheckAdmin;



// for all users and admins

// creating the order for the driver app
Route::post('/v0.1/orderPage/createOrder', [CreatingController::class, 'createOrder']);
// creating a list of products for
// getting order by ID
Route::get('/orders/{orderId}' , [CreatingController::class , 'getOrder'])->middleware('auth:sanctum');
// get all the orders for one user Past and present
Route::get('orders/history', [CreatingController::class, 'orderHistory'])->middleware('auth:sanctum');




// for drivers
// getting all orders for the driver home page
Route::get('/orders', [CreatingController::class, 'getAllOrders'])->middleware(CheckDriver::class);
// to update the state of the order and then notify the user
Route::put('/orders/{orderId}/changeState', [CreatingController::class, 'updateOrderState'])->middleware(CheckDriver::class);
// accepting the order by the driver
Route::put('/orders/{orderId}/accept' , [CreatingController::class , 'acceptOrder'])->middleware(CheckDriver::class)->middleware('auth:sanctum');
