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

	    	$client_id = Input::get('client_id');

	    	$client = DB::table('clients')->where('client_id', $client_id)->first();

			$limit = (50 < Input::get('limit') ) ? 50 : Input::get('limit');

			$blogs = DB::table('data')->orderBy('post_created_at', 'desc')->skip(Input::get('offset'))->take($limit)->get();

			$rate_limit = (int)$client->rate_limit;

			$rate_limit--;

			$this->rate_limit($client_id,$rate_limit);

			$response['data'] = $blogs;	    				

			$response['status'] = 1;

	    }		

		return Response::json($response);	
	}
	public function refresh_limits(){

		$token = Input::get('token');

		if($token && 'blah' == $token){
			
			DB::table('clients')->update(array('rate_limit' => 100 ));

		}		

	}

	public function search(){
		$rules = array(
        	
        	'q' 			=> array('required'),
        	
        	'client_id' 	=> array('required'),
        	
        	'limit' 		=> array('required')        	
	    );
		
	    $validation = Validator::make(Input::all(), $rules);

	    if($validation->fails()){	    	

	    	return $validation->messages()->toJson();

	    }else{

	    	$q = Input::get('q');	    	

	    	$client_id = Input::get('client_id');
	    	
	    	$client = DB::table('clients')->where('client_id', $client_id)->first();

	    	$limit = (50 < Input::get('limit') ) ? 50 : Input::get('limit');

			$whole_data = Data::where('status','=','1')->where('post_title', 'LIKE', "%$q%")->orderBy('post_created_at', 'desc')->skip(Input::get('offset'))->take($limit)->get();
			
			$rate_limit = (int)$client->rate_limit;

    		$rate_limit--;

    		$this->rate_limit($client_id,$rate_limit);

    		$response['data'] = $whole_data;	    				

			$response['status'] = 1;
	    }

	    return Response::json($response);
	}

	public function rate_limit($client_id,$rate_limit){
		if(DB::table('clients')->where('client_id', $client_id)->update(array('rate_limit' => $rate_limit ))){
			return 1;
		}else{
			return 0;
		}
	}
}