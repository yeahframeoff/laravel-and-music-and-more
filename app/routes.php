<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('auth',['as' => 'authIndex', 'uses' => 'AuthController@index']);
Route::get('successAuthOK', ['as' => 'successAuthOK', 'uses' => 'AuthController@successOK']);
Route::get('successAuthVK', ['as' => 'successAuthVK', 'uses' => 'AuthController@successVK']);
Route::get('successAuthFB', ['as' => 'successAuthFB', 'uses' => 'AuthController@successFB']);
Route::get('logoutAuth', ['as' => 'logoutAuth', 'uses' => 'AuthController@logout']);