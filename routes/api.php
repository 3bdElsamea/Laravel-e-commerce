<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group([
    'middleware' => ['guest:api'],
    'prefix' => 'auth'

], function ($router) {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

// Route for products only show and index
Route::apiResource('products', ProductController::class)->only(['index', 'show']);

Route::group([
    'middleware' => ['auth:api', 'isUser'],
],
    function ($router) {
        // Route for cart
        Route::apiResource('cart', CartController::class);

        // Route for order
        Route::post('order', [OrderController::class, 'store']);
    });
