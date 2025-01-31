<?php

use App\Http\Middleware\JwtMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('register', [App\Http\Controllers\AuthController::class, 'register']);
Route::post('login', [App\Http\Controllers\AuthController::class, 'login']);

Route::middleware(JwtMiddleware::class)->group(function () {
    Route::get('user', [App\Http\Controllers\AuthController::class, 'getAuthenticatedUser']);
    Route::get('logout', [App\Http\Controllers\AuthController::class, 'logout']);
});
