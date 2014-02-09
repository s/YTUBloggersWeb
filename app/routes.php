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

//Route::get('/submit', 'IndexController@submit');

Route::any('/submit', 'IndexController@submit');

Route::get('/community', 'IndexController@community');

Route::get('/cron', 'IndexController@grabber');

Route::any('/api', 'IndexController@api');

//Route::post('/api', 'IndexController@api');

Route::get('/doc', 'IndexController@doc');

Route::get('/rss', 'IndexController@rss');

Route::group(array('before'=>'api','domain' => Config::get('constants.api_host_without_http')), function()
{
	Route::get('/v1/newsletter', 'ApiController@newsletter');
	
	Route::get('/v1/search', 'ApiController@search');

	Route::get('/v1/get', 'ApiController@index');

	Route::get('/v1/refreshlimits', 'ApiController@refresh_limits');
});

Route::group(array('before' => 'guest'), function()
{
	Route::any('/login','AdminController@login' );

	//Route::post('/login','AdminController@login' );
});

Route::group(array('before' => 'auth'), function()
{
	Route::get('/dashboard', 'AdminController@dashboard');

	Route::get('/changeadminstatus', 'AdminController@changeadminstatus');;

	Route::get('/changeuserstatus', 'AdminController@changeadminstatus');;

	//Route::get('/settings', 'AdminController@settings');

	Route::any('/settings', 'AdminController@settings');

	Route::get('/adminlist', 'AdminController@adminlist');

	Route::get('/userlist', 'AdminController@userlist');

	Route::any('/addnewadmin', 'AdminController@addnewadmin');

	//Route::post('/addnewadmin', 'AdminController@addnewadmin');

	Route::get('/logout', 'AdminController@logout');
});

//Route::get('/fix', 'IndexController@fix');

Route::get('/weeklynewsletter', 'IndexController@weeklynewsletter');

Route::get('/search', 'IndexController@search');

Route::post('/newsletter', 'IndexController@newsletter');

//Route::get('/postalltweets', 'IndexController@postalltweets');

Route::get('/{slug}', 'IndexController@permalink');

App::missing(function($exception) 
{		
	//print_r($exception);exit;
    return Redirect::to('/');
});