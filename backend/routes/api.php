<?php

use App\Http\Middleware\JwtMiddleware;
use Illuminate\Support\Facades\Route;

Route::post('register', [App\Http\Controllers\AuthController::class, 'register']);
Route::post('login', [App\Http\Controllers\AuthController::class, 'login']);
Route::get('posts', [App\Http\Controllers\PostController::class, 'index']);
Route::get('posts/{post}', [App\Http\Controllers\PostController::class, 'show']);

Route::middleware(JwtMiddleware::class)->group(function () {
    Route::get('user', [App\Http\Controllers\AuthController::class, 'getAuthenticatedUser']);
    Route::post('logout', [App\Http\Controllers\AuthController::class, 'logout']);

    Route::post('posts', [App\Http\Controllers\PostController::class, 'store']);
    Route::put('posts/{post}', [App\Http\Controllers\PostController::class, 'update']);
    Route::delete('posts/{post}', [App\Http\Controllers\PostController::class, 'destroy']);
    // Route::apiResource('posts', App\Http\Controllers\PostController::class);

    Route::apiResource('posts.comments', App\Http\Controllers\PostCommentController::class);
    Route::post('posts/{post}/likes', [App\Http\Controllers\PostLikeController::class, 'store']);
    Route::delete('posts/{post}/likes', [App\Http\Controllers\PostLikeController::class, 'destroy']);

    Route::apiResource('videos', App\Http\Controllers\VideoController::class);

    Route::apiResource('news', App\Http\Controllers\NewsController::class);
});
