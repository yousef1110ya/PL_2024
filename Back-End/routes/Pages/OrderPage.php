<?php

use App\Http\Controllers\Auth\DriverAuthController;
use App\Http\Controllers\HomePage\StoreController;
use App\Http\Controllers\Order\CreatingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckDriver;

// creating the order for the driver app
Route::post('/HomePage/getStore/{storeId}/product/{productId}', [CreatingController::class, 'createOrder']);

// getting all orders for the driver home page
Route::get('/orders', [CreatingController::class, 'getAllOrders']);