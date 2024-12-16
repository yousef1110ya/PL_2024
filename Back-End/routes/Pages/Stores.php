<?php

use App\Http\Controllers\Auth\DriverAuthController;
use App\Http\Controllers\HomePage\StoreController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckDriver;
use App\Http\Middleware\CheckAdmin;




// creating a store
Route::post('/Stores/create', [StoreController::class, 'createStore'])->middleware('auth:sanctum')->middleware(CheckAdmin::class);