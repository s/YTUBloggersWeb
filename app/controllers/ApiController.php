<?php

class ApiController extends Controller {

	public function index(){

		$rules = array(
        	
        	'client_token' 	=> array('required'),
        	
        	'client_id' 	=> array('required'),
        	
        	'limit' 		=> array('required')
        	
        	//'offset' 		=> array('required')
	    );

	    $validation = Validator::make(Input::all(), $rules);

	    if($validation->fails()){	    	

	    	return $validation->messages()->toJson();

	    }else{

	    	$client = DB::table('clients')->where('client_id', Input::get('client_id'))->first();

	    	if(sizeof($client)){	    		

	    		if($client->client_token == Input::get('client_token')){

	    			if( 0 < $client->rate_limit ){

	    				$limit = (50 < Input::get('limit') ) ? 50 : Input::get('limit');

	    				$blogs = DB::table('data')->orderBy('post_created_at', 'desc')->skip(Input::get('offset'))->take($limit)->get();

	    				$rate_limit = (int)$client->rate_limit;

	    				$rate_limit--;

	    				DB::table('clients')->where('client_id', Input::get('client_id'))->update(array('rate_limit' => $rate_limit ));

	    				$response['data'] = $blogs;	    				

	    				$response['status'] = 1;	    				

	    			}else{

	    				$response['message'] = 'Your rate limit exceeded.';

			    		$response['status'] = 0;			    		

	    			}

	    		}else{
	    			
	    			$response['message'] = 'Client token is wrong.';

		    		$response['status'] = 0;		    		
	    		}

	    	}else{

	    		$response['message'] = 'Client not recognized.';

	    		$response['status'] = 0;

	    	}

	    }		

		return Response::json($response);	
	}
	public function refresh_limits(){

		$token = Input::get('token');

		if($token && 'OzA.s187ajMQa.OqFggH' == $token){
			
			DB::table('clients')->update(array('rate_limit' => 100 ));

		}		

	}	
}