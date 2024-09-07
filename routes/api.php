<?php

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
// Route::post('/register', [ApiController::class, 'register']);
// Route::post('/login', [ApiController::class, 'login']);
// Route::middleware(['auth:sanctum'])->group(function(){
// Route::get('/profile', [ApiController::class, 'profile']);
// Route::post('/logout', [ApiController::class, 'logout']);

// });

Route::apiResource('posts', PostController::class);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware(['auth:sanctum']);