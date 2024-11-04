<?php

use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserContoller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

/**
 * Default Route - /
 */
Route::get('/', function () {
    return response()->json([
        'version' => '1.0.0',
        'message' => 'Welcome to v1 REST API',
    ], Response::HTTP_OK);
});


// For users
Route::post('/register', [UserContoller::class, 'login']);
Route::post('/login', [UserContoller::class, 'login']);
Route::post('/logout', [UserContoller::class, 'logout']);

// For tasks
Route::apiResource('tasks', TaskController::class);
