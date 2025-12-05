<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\BuyerController;

Route::post('/buyers/register', [BuyerController::class, 'store']);
Route::get('/buyers', [BuyerController::class, 'index']);
Route::get('/buyers/{id}', [BuyerController::class, 'show']);

use App\Http\Controllers\SellerController;

Route::post('/sellers/register', [SellerController::class, 'store']);
Route::get('/sellers', [SellerController::class, 'index']);
Route::get('/sellers', [SellerController::class, 'index']);
Route::get('/sellers/{id}', [SellerController::class, 'show']);

use App\Http\Controllers\FoodController;

Route::post('/foods', [FoodController::class, 'store']);
Route::delete('/foods/{id}', [FoodController::class, 'destroy']);
Route::get('/foods', [FoodController::class, 'index']);
Route::get('/sellers/{sellerId}/foods', [FoodController::class, 'getBySeller']);
Route::get('/foods/category/{category}', [FoodController::class, 'getByCategory']);
Route::get('/foods/{id}', [FoodController::class, 'show']);
Route::put('/foods/{id}', [FoodController::class, 'update']);

use App\Http\Controllers\TransactionController;

Route::post('/transactions', [TransactionController::class, 'store']);
Route::get('/buyers/{buyerId}/transactions', [TransactionController::class, 'getByBuyer']);
Route::get('/sellers/{sellerId}/transactions', [TransactionController::class, 'getBySeller']);
Route::put('/transactions/{id}/status', [TransactionController::class, 'updateStatus']);
