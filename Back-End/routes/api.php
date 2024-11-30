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

require __DIR__ . '/Auth/user-auth.php';
require __DIR__ . '/Auth/admin-auth.php';