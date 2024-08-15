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

Route::get('/sms', function () {
    return view('send-msg');
});

Route::get('/login-page', function () {
    return view('login');
});

Route::get('/register-page', function () {
    return view('register');
});

Route::post('/send-sms',[Controller::class,'sendSms'])->name('sendSms');


Route::get('/history', function () {
    return view('history');
})->name('history');



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
