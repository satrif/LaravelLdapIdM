<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/destroy', 'IpaAuthController@destroy_session')->name('destroy');
//initial welcome - will require login IPA
Route::get('/', function (Request $request) {
    return view('welcome', ['roleArr' => $request->roleArr]);
})->middleware('auth.check')->middleware('role.check:any')->name('welcome');
//login screen, redirect after to welcome
Route::get('/login', function () {
    return view('login');
})->name('login');
//login handler IPA
Route::post('/login', 'IpaAuthController@user_login');
