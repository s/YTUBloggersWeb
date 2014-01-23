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

Route::get('/', 'IndexController@index');

Route::get('/submit', 'IndexController@submit');

Route::post('/submit', 'IndexController@submit');

Route::get('/community', 'IndexController@community');

Route::get('/cron', 'IndexController@grabber');

Route::get('/api', 'IndexController@api');

Route::post('/api', 'IndexController@api');

Route::get('/doc', 'IndexController@doc');

Route::group(array('domain' => Config::get('constants.api_host_without_http')), function()
{
	Route::get('/get', 'ApiController@index');

	Route::get('/refreshlimits', 'ApiController@refresh_limits');
});

App::missing(function($exception) 
{
    return Redirect::to('/');
});