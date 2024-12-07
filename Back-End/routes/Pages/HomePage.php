<?php

use App\Http\Controllers\Auth\DriverAuthController;
use App\Http\Controllers\HomePage\StoreController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckDriver;


Route::post('/HomePage/search', [StoreController::class, 'search']);
// getting the product from the store id
Route::get('/HomePage/profile/{id}', [StoreController::class, 'getUserById'])->middleware('auth:sanctum');

require __DIR__ . '/Stores.php';
require __DIR__ . '/Products.php';