<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('order');
});


Route::get('/', [OrderController::class, 'index']);
Route::post('/order', [OrderController::class, 'store']);


// ROUTE KHUSUS ADMIN
Route::prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'loginForm']);
    Route::post('/login', [AdminController::class, 'login']);
    Route::get('/dashboard', [AdminController::class, 'dashboard']);
    Route::post('/update/{id}', [AdminController::class, 'updateStatus']);
    Route::get('/logout', [AdminController::class, 'logout']);
});

require __DIR__.'/auth.php';
