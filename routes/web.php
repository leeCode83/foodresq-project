<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BuyerController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\CartController;

// --- View Routes ---

Route::get('/', function () {return view('landing.index');})->name('landing.index');
Route::get('/login', function () {return view('auth.buyer');})->name('auth.buyer');
Route::get('/seller/login', function () {return view('auth.seller');})->name('auth.seller');
Route::get('/browse', [FoodController::class, 'index'])->name('food.index');
Route::get('/food/search', [FoodController::class, 'search'])->name('food.search');
Route::get('/food/detail/{id}', [FoodController::class, 'show'])->name('food.detail');
Route::get('/checkout', function () {return view('checkout.index');})->name('checkout.index');
Route::get('/my-orders', [BuyerController::class, 'orders'])->name('buyer.orders');

// --- Seller Routes ---
Route::prefix('seller')->group(function () {
    Route::get('/dashboard', [SellerController::class, 'dashboard'])->name('seller.dashboard');
    Route::get('/food/create', function () {
        return view('seller.food_form');
    })->name('seller.food_form');
    // auth
    Route::post('/register', [SellerController::class, 'store'])->name('seller.register.submit');
    Route::post('/login', [SellerController::class, 'login'])->name('seller.login.submit');
    Route::post('/logout', [SellerController::class, 'logout'])->name('seller.logout');
    // foods
    Route::get('/foods', [FoodController::class, 'sellerIndex'])->name('seller.foods.index');
    Route::get('/foods/{id}/edit', [FoodController::class, 'edit'])->name('seller.foods.edit');
    Route::put('/foods/{id}', [FoodController::class, 'update'])->name('seller.foods.update');
    Route::delete('/foods/{id}', [FoodController::class, 'destroy'])->name('seller.foods.destroy');
});

// Buyer Auth
Route::post('/buyers/register', [BuyerController::class, 'store'])->name('buyer.register.submit');
Route::post('/buyers/login', [BuyerController::class, 'login'])->name('buyer.login.submit');
Route::post('/buyers/logout', [BuyerController::class, 'logout'])->name('buyer.logout');
Route::get('/buyers', [BuyerController::class, 'index']);
Route::get('/buyers/{id}', [BuyerController::class, 'show']);

Route::get('/sellers', [SellerController::class, 'index']);
Route::get('/sellers/{id}', [SellerController::class, 'show']);

// foods
Route::post('/foods', [FoodController::class, 'store'])->name('food.store');
Route::get('/foods', [FoodController::class, 'index']);
Route::get('/sellers/{sellerId}/foods', [FoodController::class, 'getBySeller']);
Route::get('/foods/category/{category}', [FoodController::class, 'getByCategory'])->name('food.category');
Route::get('/foods/{id}', [FoodController::class, 'show']);

// Cart
Route::get('/add-to-cart/{id}', [CartController::class, 'addToCart'])->name('cart.add');
Route::delete('/remove-from-cart', [CartController::class, 'removeFromCart'])->name('cart.remove');

// Transactions
Route::post('/transactions', [TransactionController::class, 'store'])->name('transaction.store');
Route::post('/transactions/verify', [TransactionController::class, 'verify'])->name('transaction.verify');
Route::get('/buyers/{buyerId}/transactions', [TransactionController::class, 'getByBuyer']);
Route::get('/sellers/{sellerId}/transactions', [TransactionController::class, 'getBySeller']);
Route::put('/transactions/{id}/status', [TransactionController::class, 'updateStatus']);