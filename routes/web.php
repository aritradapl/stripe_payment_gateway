<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StripePayment;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/',[UserController::class,'index'])->name('index');
Route::post('/user/make/payment',[StripePayment::class,'userData'])->name('user.payment');
Route::get('/user/payment/success',[StripePayment::class,'paymentSuccess'])->name('checkout-success');
Route::get('/user/payment/cancel',[UserController::class,'cancel'])->name('checkout-cancel');