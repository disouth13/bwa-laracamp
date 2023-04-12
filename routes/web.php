<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\User\CheckoutController;
use App\Http\Controllers\Admin\DiscountController;
use App\Http\Controllers\Admin\CheckoutController as AdminCheckout;
use App\Http\Controllers\User\DashboardController as UserDashboard;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;


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





// sign googel
Route::get('login-google', [UserController::class, 'LoginGoogle'])->name('login-google');

// handle provider callback setelah login
Route::get('auth/google/callback', [UserController::class, 'HandleProviderCallback'])->name('user-google-callback');

// midtrans callback
Route::get('payment/success', [CheckoutController::class, 'midtransCallback']);
Route::post('payment/success', [CheckoutController::class, 'midtransCallback']);

Route::middleware(['auth'])->group(function () {

    // checkout controller
    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout-success')->middleware('userRole:user');
    Route::get('/checkout/{camp:slug}', [CheckoutController::class, 'create'])->name('checkout-create')->middleware('userRole:user');
    Route::post('/checkout/{camp}', [CheckoutController::class, 'store'])->name('checkout-store')->middleware('userRole:user');

    Route::get('dashboard/checkout/invoice/{checkout}', [CheckoutController::class, 'invoice'])->name('user-checkout-invoice');


    // route homecontroller
    Route::get('dashboard', [HomeController::class, 'dashboard'])->name('home-dashboard');

    // user dashboard
    Route::prefix('user/dashboard')->namespace('User')->name('user.')->middleware('userRole:user')->group(function(){
        Route::get('/', [UserDashboard::class, 'index'])->name('dashboard');
    });

     // admin dashboard
    Route::prefix('admin/dashboard')->name('admin.')->middleware('userRole:admin')->group(function(){
        Route::get('/', [AdminDashboard::class, 'index'])->name('dashboard');
        Route::post('checkout/{checkout}', [AdminCheckout::class, 'update'])->name('admin-checkout-update');

        // admin discount
        Route::resource('discount', DiscountController::class);
    });

});


// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
