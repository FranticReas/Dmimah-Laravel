<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductIngredientController;
use App\Http\Controllers\StockController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::resources([
        'dashboard' => DashboardController::class,
        'customer' => CustomerController::class,
        'stock' => StockController::class,
        'product' => ProductController::class,
        'order' => OrderController::class,
    ]);
    Route::post(
        '/product/{product}/bahan',
        [ProductController::class, 'storeBahan']
    )->name('product.bahan.store');
    Route::put('/product-ingredient/{id}', [ProductIngredientController::class, 'update'])
        ->name('product-ingredient.update');
    Route::delete('/product-ingredient/{id}', [ProductIngredientController::class, 'destroy'])
        ->name('product-ingredient.destroy');

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate'])->name('login.authenticate');
});
