<?php

use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;

// Default route
Route::get('/', function () {
    return response()->json([
        'version' => '1.0.0',
        'message' => 'Welcome to v1 REST API',
    ], Response::HTTP_OK);
});

Route::prefix('users')->controller(UserController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
});

// Protected routes of task and logout
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/users/logout', [UserController::class, 'logout']);
    Route::apiResource('tasks', TaskController::class);
});
