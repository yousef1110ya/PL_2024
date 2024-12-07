<?php

use App\Http\Controllers\Auth\DriverAuthController;
use App\Http\Controllers\HomePage\StoreController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckDriver;
use App\Http\Middleware\CheckAdmin;

// getting all stores
Route::get('/Stores/getStores', [StoreController::class, 'getStores']);
// getting store tags
Route::get('/Stores/storeTags', [StoreController::class, 'getStoreTags']);
//getting store
//with getting the store we got all the products from that store
Route::get('/Stores/{id}', [StoreController::class, 'getStore']);
// getting the product from the store id
//Route::get('/Stores/{storeId}/product/{productId}', [StoreController::class, 'getProductDetails']);

// helping with some dashboard functions for filling up the DB


// creating a store
Route::post('/Stores/create', [StoreController::class, 'createStore'])->middleware('auth:sanctum')->middleware(CheckAdmin::class);
