<?php

use App\Http\Controllers\Dashboard\NotficationsController;
use App\Http\Controllers\Dashboard\OrderController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Route Group for Auth Middleware
Route::group(['middleware' => ['auth','isAdmin']], function () {
    Route::get('/', [OrderController::class, 'index'])->name('home');
    Route::get('/order/{order}', [OrderController::class, 'show'])->name('showOrder');
    Route::get('/notifications', [NotficationsController::class, 'index'])->name('notifications');

});

Auth::routes();

