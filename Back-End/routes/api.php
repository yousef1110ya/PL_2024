<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// the User Main API's 
Route::post('/User/registerUser', [AuthController::class, 'register']);
Route::post('/User/loginUser', [AuthController::class, 'login']);
Route::post('/User/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::post('/User/uplodeProfile', [UserController::class, 'uploadProfileImage'])->middleware('auth:sanctum');


// the Product Main API's
