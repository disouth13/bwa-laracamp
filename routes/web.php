<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\User\CheckoutController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout-success');
Route::get('/checkout/{camp:slug}', [CheckoutController::class, 'create'])->name('checkout-create');
Route::post('/checkout/{camp}', [CheckoutController::class, 'store'])->name('checkout-store');


// sign googel
Route::get('login-google', [UserController::class, 'LoginGoogle'])->name('login-google');

// handle provider callback setelah login
Route::get('auth/google/callback', [UserController::class, 'HandleProviderCallback'])->name('user-google-callback');



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
