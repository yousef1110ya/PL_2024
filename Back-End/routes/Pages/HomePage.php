<?php

use App\Http\Controllers\Auth\DriverAuthController;
use App\Http\Controllers\HomePage\StoreController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckDriver;


Route::get('/HomePage/getStores', [StoreController::class, 'getStores']);
Route::get('/HomePage/storeTags', [StoreController::class, 'getStoreTags']);
Route::post('/HomePage/search', [StoreController::class, 'search']);
Route::get('/HomePage/getStore/{id}', [StoreController::class, 'getStore']);
// getting the product from the store id
Route::get('/HomePage/getStore/{storeId}/product/{productId}', [StoreController::class, 'getProductDetails']);
Route::get('/HomePage/Prodile/{id}', [StoreController::class, 'getUserById'])->middleware('auth:sanctum');
