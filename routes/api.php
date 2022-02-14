<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::match(['get','post'], '/sign-up', 'UserController@sign_up');
Route::match(['get','post'], '/login', 'UserController@login')->name('login') ;
Route::match(['get','post'], '/change-password', 'UserController@change_password');
Route::match(['get','post'], '/forget-password', 'UserController@forget_password');
Route::match(['get','post'], '/confirm-otp', 'UserController@confirm_otp');
Route::match(['get','post'], '/shop', 'UserController@shop');
Route::match(['get','post'], '/engineer', 'UserController@engineer');

