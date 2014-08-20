<?php

/** Models */
Route::model('user', 'Karma\Entities\User');

/** Auth stuff */
Route::get('login/{provider}', array('as' => 'auth.login', 
                                     'uses' => 'Karma\Controllers\AuthController@login'));

Route::get('login/{provider}/callback', array('as' => 'auth.login.callback',
                                              'uses' => 'Karma\Controllers\AuthController@callback'));

Route::get('logout', array('as' => 'auth.logout', 
                           'uses' => 'Karma\Controllers\AuthController@logout'));

Route::get('user/{social}', 'Karma\Controllers\AuthController@loadProfile');

Route::group(array('before' => 'auth'), function()
{

    /*  profile */

    Route::get('profile', ['as' => 'profileIndex', 'uses' => 'Karma\Controllers\ProfileController@index']);
    Route::get('profile/{user}', ['as' => 'profile', 'uses' => 'Karma\Controllers\ProfileController@show']);
    Route::get('import', array('as' => 'import',
                               'uses' => 'Karma\Controllers\ImportController@index'));
    /*  friendship */

    Route::get('friends',
              ['as'   => 'friends.my',
               'uses' => 'Karma\Controllers\FriendController@getAllMy']);

    Route::get('friends/{user}',
              ['as'   => 'friends',
               'uses' => 'Karma\Controllers\FriendController@getAll']);

    Route::get('friends/add/{user}',
              ['as'   => 'friends.add',
               'uses' => 'Karma\Controllers\FriendController@add']);

    Route::get('friends/cancel/{user}',
              ['as'   => 'friends.cancel',
               'uses' => 'Karma\Controllers\FriendController@cancel']);

    Route::get('friends/confirm/{user}',
              ['as'   => 'friends.confirm',
               'uses' => 'Karma\Controllers\FriendController@confirm']);

    Route::get('friends/delete/{user}',
              ['as'   => 'friends.delete',
               'uses' => 'Karma\Controllers\FriendController@delete']);

    Route::get('friends/restore/{user}',
              ['as'   => 'friends.restore',
               'uses' => 'Karma\Controllers\FriendController@restore']);

    Route::get('connect/{provider}', array('as' => 'auth.connect',
                                           'uses' => 'Karma\Controllers\AuthController@connect'));

    Route::get('connect/{provider}/callback', array('as' => 'auth.connect.callback',
                                                    'uses' => 'Karma\Controllers\AuthController@callbackConnect'));

});

/** Homepage */
Route::get('/', ['as' => 'home', 'uses' => 'Karma\Controllers\MainController@index']);
Route::get('about', 'Karma\Controllers\MainController@about');
Route::get('rights', 'Karma\Controllers\MainController@rights');
