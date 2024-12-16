<?php

use App\Http\Controllers\Auth\DriverAuthController;
use App\Http\Controllers\HomePage\StoreController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckDriver;


Route::post('/v0.1/HomePage/search', [StoreController::class, 'search']);
/*
    the search function will wait from the user a query
    and then will return 2 json objects one for stores that have the query in thier name
    and the other json obj is a list of the products that have the query
*/
// getting the product from the store id
Route::get('/v0.1/HomePage/profile/{id}', [StoreController::class, 'getUserById'])->middleware('auth:sanctum');
/*
    this route will need only the user and the token
*/
// getting all the stores paginated
Route::get('/v0.1/HomePage/getStores', [StoreController::class, 'getStores']);
/*
    getting all the stores for the home page is public so we will not be waiting for any data from the front
*/
// geting one store
Route::get('/v0.1/HomePage/getStoreById/{id}', [StoreController::class, 'getStore']);
/*
    this route is also public with the only need is to get the id from the url
*/


require __DIR__ . '/Stores.php';
require __DIR__ . '/Products.php';