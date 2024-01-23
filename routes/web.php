<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormController;
use App\Http\Controllers\LoginController;

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
Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate'])->middleware('guest');
Route::get('/logout', [LoginController::class, 'logout'])->middleware('auth');


Route::get('/form', [FormController::class, 'form']);
Route::post('/storeform', [FormController::class, 'store']);
Route::get('/thankyou', [FormController::class, 'thankyou']);
Route::get('/error', [FormController::class, 'error']);
Route::get('/email', [FormController::class, 'Email']);


Route::get('/home', [FormController::class, 'index'])->middleware('auth');
Route::post('/formedit', [FormController::class, 'formedit'])->middleware('auth');
Route::get('/editform', [FormController::class, 'edit'])->middleware('auth');
Route::post('/updateform', [FormController::class, 'update'])->middleware('auth');
Route::post('/deletefiles', [FormController::class, 'deletefiles'])->middleware('auth');