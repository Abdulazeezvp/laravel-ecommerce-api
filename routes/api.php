<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;


Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('products/list', [ProductController::class, 'index']);
Route::post('product/{id}', [ProductController::class, 'show']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::apiResource('orders', OrderController::class);
    Route::middleware([AdminMiddleware::class])->group(function () {
        Route::apiResource('users', UserController::class);
        Route::post('register-admin', [AuthController::class, 'registerAdmin']);
        Route::apiResource('products', ProductController::class);
    });
});

