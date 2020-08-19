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
Route::namespace('Api')->group(function(){
    // Admin
    Route::name('Admin.')->prefix('admin')->namespace('Admin')->group(function(){
        Route::post('login', 'LoginController@login')->name('Login');
        // need token
        Route::middleware('jwt')->group(function(){
            Route::post('logout', 'LoginController@logout')->name('Logout');
            Route::post('refresh', 'LoginController@refresh')->name('Refresh');
            Route::get('me', 'LoginController@me')->name('Me');
        });
    });

    // User
    Route::name('User.')->prefix('user')->namespace('User')->group(function(){
        Route::post('login', 'LoginController@login')->name('Login');
          // need token
        Route::middleware('jwt')->group(function(){
            Route::post('logout', 'LoginController@logout')->name('Logout');
            Route::post('refresh', 'LoginController@refresh')->name('Refresh');
            Route::get('me', 'LoginController@me')->name('Me');
        });
    });

});