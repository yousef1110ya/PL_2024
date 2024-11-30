<?php

use App\Http\Controllers\Auth\UserAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/user/register', [UserAuthController::class, 'register']);

