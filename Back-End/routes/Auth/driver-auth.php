<?php

use App\Http\Controllers\Auth\DriverAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckDriver;

Route::post('/driver/login', [DriverAuthController::class, 'login']);
Route::post('/driver/logout', [DriverAuthController::class, 'logout'])->middleware(CheckDriver::class)->middleware('auth:sanctum');