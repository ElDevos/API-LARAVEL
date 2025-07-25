<?php

use App\Http\Controllers\LaboratorioController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\JwtMiddleware;
use App\Http\Controllers\OrderController;

Route::get('/', function () {
    return response()->json(['message' => 'Hello world!']);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('jwt')->group(function () {
    Route::get('/user', [AuthController::class, 'getUser']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::put('/updateuser', [AuthController::class, 'updateUser']);
   
});
Route::middleware('jwt.auth')->group(function () {
    Route::get('/orders/{user_id}', [OrderController::class, 'getUserOrders']);
    Route::put('/order', [OrderController::class, 'storeOrder']);
});

