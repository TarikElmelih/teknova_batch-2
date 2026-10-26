<?php
use App\Http\Controllers\ProductController;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

Route::get('/products/{id}', [ProductController::class, 'index']);
Route::get('/test', [ProductController::class, 'store']);
// Route::get('/home', );
