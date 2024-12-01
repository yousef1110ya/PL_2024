<?php

use App\Http\Controllers\Auth\DriverAuthController;
use App\Http\Controllers\HomePage\StoreController;
use App\Http\Controllers\HomePage\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckDriver;
use App\Http\Middleware\CheckAdmin;


// getting the product from the store id
Route::get('/Stores/{storeId}/product/{productId}', [StoreController::class, 'getProductDetails']);
// adding the product to the shopping list of the user
Route::post('/product/{productId}/addToCart', [ProductController::class, 'addToCart']);

// functions helping for the dashboard

// creating a new Product

Route::post('/Stores/{storeId}/product', [ProductController::class , 'store'])->middleware(CheckAdmin::class);;