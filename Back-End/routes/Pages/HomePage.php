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