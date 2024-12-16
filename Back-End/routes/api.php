<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Middleware\CheckAdmin;
/*
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
*/


Route::post('/test', function (Request $request) {
    return 'welcome Admin';
})->middleware('auth:sanctum')->middleware(CheckAdmin::class);

// the API's for users auth with all roles
require __DIR__ . '/Auth/user-auth.php';
require __DIR__ . '/Auth/admin-auth.php';
require __DIR__ . '/Auth/driver-auth.php';
require __DIR__ . '/Pages/HomePage.php';
require __DIR__ . '/Pages/OrderPage.php';
