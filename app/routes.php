<?php

/** Models */
Route::model('user', 'Karma\Entities\User');

/** Auth stuff */
Route::get('login/{provider}', array('as' => 'auth.login', 
                                     'uses' => 'Karma\Controllers\AuthController@login'));

Route::get('login/{provider}/callback', array('as' => 'auth.callback',
                                              'uses' => 'Karma\Controllers\AuthController@callback'));

Route::get('logout', array('as' => 'auth.logout', 
                           'uses' => 'Karma\Controllers\AuthController@logout'));

Route::get('user/{social}', 'Karma\Controllers\AuthController@loadProfile');

/** Profile routes */
Route::group(array('before' => 'auth'), function()
{
    Route::get('profile/{user}', ['as' => 'profile', 'uses' => 'Karma\Controllers\ProfileController@show']);
    Route::get('profile/addFriend/{user}', 'Karma\Controllers\ProfileController@addFriend');
    Route::get('profile/{user}/friends', 'Karma\Controllers\ProfileController@getAllFriends');
    Route::get('profile/confirmFriend/{user}', 'Karma\Controllers\ProfileController@confirmFriend');
    Route::get('profile/deleteFriend/{user}', 'Karma\Controllers\ProfileController@deleteFriend');
    
    Route::get('import', array('as' => 'import',
                               'uses' => 'Karma\Controllers\ImportController@index'));
});

/** Homepage */
Route::get('/', ['as' => 'home', 'uses' => 'Karma\Controllers\MainController@index']);
Route::get('about', 'Karma\Controllers\MainController@about');
Route::get('rights', 'Karma\Controllers\MainController@rights');

Route::get('/friends/{user}', ['as' => 'friends', 'uses' => 'Karma\Controllers\FriendController@index']);