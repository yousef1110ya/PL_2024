<?php

use App\Http\Controllers\Auth\DriverAuthController;
use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\HomePage\StoreController;
use App\Http\Controllers\Order\CreatingController;
use App\Http\Controllers\DashController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckDriver;
use App\Http\Middleware\CheckAdmin;

// Product Functions

// create product
Route::post('/v0.1/Dash/{StoreId}/createProduct', [DashController::class, 'createProduct'])->middleware('auth:sanctum')->middleware(CheckAdmin::class);
// edit product 
Route::put('/v0.1/Dash/editProduct/{id}', [DashController::class, 'editProduct'])->middleware('auth:sanctum')->middleware(CheckAdmin::class);
// delete product 
Route::delete('/v0.1/Dash/deleteProduct/{productId}', [DashController::class, 'deleteProduct'])->middleware('auth:sanctum')->middleware(CheckAdmin::class);


// store functions

// create a store
Route::post('/v0.1/Dash/createStore', [DashController::class, 'createStore'])->middleware('auth:sanctum')->middleware(CheckAdmin::class);
// edit store 
Route::put('/v0.1/Dash/editStore/{storeId}', [DashController::class, 'editStore'])->middleware('auth:sanctum')->middleware(CheckAdmin::class);
Route::delete('/v0.1/Dash/deleteStore/{storeId}', [DashController::class, 'deleteStore'])->middleware('auth:sanctum')->middleware(CheckAdmin::class);
