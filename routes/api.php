<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AppointmentController;

Route::apiResource('appointments', AppointmentController::class);
Route::apiResource('users', UserController::class);
Route::post('products', [ProductController::class, 'AddToCart']);

require __DIR__.'/auth.php';
