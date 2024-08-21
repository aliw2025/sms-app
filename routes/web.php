<?php

use Illuminate\Support\Facades\Route;
use UI\Control;
use App\Http\Controllers\Controller;

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

Route::get('/',[Controller::class,'index'])->name('index');

Route::get('/home',[Controller::class,'index'])->name('home');


Route::get('/login-page', function () {
    return view('login');
})->name('login-page');

Route::get('/register-page', function () {
    return view('register');
})->name('register-page');


Route::get('fetch-transactions', [Controller::class, 'fetchTransactions'])->name('transactions.fetch');
Route::get('transaction-details/{id}', [Controller::class, 'showDetails'])->name('transaction.details');


Route::post('/send-sms',[Controller::class,'sendSms'])->name('sendSms');

Route::get('/history', [Controller::class, 'history'])->name('history');



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
