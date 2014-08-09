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

Route::get('auth',['as' => 'authIndex', 'uses' => 'Karma\Controllers\AuthController@index']);
Route::get('successAuthOK', ['as' => 'successAuthOK', 'uses' => 'Karma\Controllers\AuthController@successOK']);
Route::get('successAuthVK', ['as' => 'successAuthVK', 'uses' => 'Karma\Controllers\AuthController@successVK']);
Route::get('successAuthFB', ['as' => 'successAuthFB', 'uses' => 'Karma\Controllers\AuthController@successFB']);
Route::get('logoutAuth', ['as' => 'logoutAuth', 'uses' => 'Karma\Controllers\AuthController@logout']);
Route::get('user/{socialId}', 'Karma\Controllers\AuthController@loadProfile');


Route::group(array('before' => 'auth'), function()
{
    Route::get('profile/{user}', ['as' => 'profile', 'uses' => 'Karma\Controllers\ProfileController@show']);
    Route::get('profile/addFriend/{user}', 'Karma\Controllers\ProfileController@addFriend');
    Route::get('profile/{user}/friends', 'Karma\Controllers\ProfileController@getAllFriends');
    Route::get('profile/confirmFriend/{user}', 'Karma\Controllers\ProfileController@confirmFriend');
    Route::get('profile/deleteFriend/{user}', 'Karma\Controllers\ProfileController@deleteFriend');
});
Route::model('user', 'Karma\Entities\User');