<?php

use App\Http\Controllers\Auth\UserAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/user/createUser', [UserAuthController::class, 'create']);
Route::post('/user/userRegister', [UserAuthController::class, 'registerUser']);
Route::post('/user/login', [UserAuthController::class, 'login']);
Route::post('/user/logout', [UserAuthController::class, 'logout'])->middleware('auth:sanctum');
