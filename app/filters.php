<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	//
});


App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	
	if(!Session::has('user')){
		return Redirect::to('/');
	}
	
});

Route::filter('api', function()
{

	$fail = 0;

	if(strlen(Input::get('client_id'))){
		
		$client = DB::table('clients')->where('client_id', Input::get('client_id'))->first();

		if(!sizeof($client)){
			$response['message'] = 'Client not recognized.';

			$response['status'] = 0;			
		}else{
			if($client->client_token == Input::get('client_token')){

    			if( 0 < $client->rate_limit ){

    				

    			}else{

    				$fail = 1;

    				$response['message'] = 'Your rate limit exceeded.';

		    		$response['status'] = 0;			    		

    			}

    		}else{
 				
 				$fail = 1;

    			$response['message'] = 'Client token is wrong.';

	    		$response['status'] = 0;		    		
    		}
		}
	}else{

		$fail = 1;

		$response['message'] = 'Client not recognized.';

		$response['status'] = 0;

	}

	if ($fail) {
		return Response::json($response);
	}	
	
});

Route::filter('guest', function()
{
	
	if(Session::has('user')){
		return Redirect::to('/dashboard');
	}
	
});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/dashboard')->with('flash_notice', 'You are already logged in!');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});