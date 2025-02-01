<?php

use App\Http\Middleware\JwtMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('register', [App\Http\Controllers\AuthController::class, 'register']);
Route::post('login', [App\Http\Controllers\AuthController::class, 'login']);

Route::middleware(JwtMiddleware::class)->group(function () {
    Route::get('user', [App\Http\Controllers\AuthController::class, 'getAuthenticatedUser']);
    Route::post('logout', [App\Http\Controllers\AuthController::class, 'logout']);

    Route::apiResource('posts', App\Http\Controllers\PostController::class);
    Route::apiResource('posts.comments', App\Http\Controllers\PostCommentController::class);

    Route::post('posts/{post}/likes', [App\Http\Controllers\PostLikeController::class, 'store']);
    Route::delete('posts/{post}/likes/{like}', [App\Http\Controllers\PostLikeController::class, 'destroy']);
});
