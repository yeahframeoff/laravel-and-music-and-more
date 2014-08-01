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

Route::get('vk', ['as' => 'vkIndex', 'uses' => 'VkAuthController@index']);

Route::get('vk/get-token', ['as' => 'vkGetToken', 'uses' => 'VkAuthController@getToken']))
