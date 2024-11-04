<?php

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'version' => '1.0.0',
        'message' => 'Welcome to v1 REST API',
    ], Response::HTTP_OK);
});
