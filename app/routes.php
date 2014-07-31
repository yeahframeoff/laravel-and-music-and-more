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

Route::get('/', function()
{
	return View::make('hello');
});

Route::get('vk', ['as' => 'vkindex', 'uses' => 'VkController@index']);

Route::get('vk/edit/{song_id}/{new_artist}', 'VkController@editSound')
    ->where(['song_id' => '[0-9]+']);