<?php

use App\Http\Controllers\Auth\UserAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


//Route::post('/v0.1/user/createUser', [UserAuthController::class, 'create']);
Route::post('/v0.1/user/userRegister', [UserAuthController::class, 'registerUser']);
Route::post('/v0.1/user/login', [UserAuthController::class, 'login']);
Route::post('/v0.1/user/logout', [UserAuthController::class, 'logout'])->middleware('auth:sanctum');