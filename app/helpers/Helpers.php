<?php

class Helpers{

	public static function subscribe($input){
		if(sizeof($input)){
			
			$rules = array(	        	
	        	'email'		=> array('required','unique:subscriptions,email')
		    );		    

		    $validation = Validator::make($input, $rules);

		    if(!$validation->fails()){

		    	try{
		    		$insert = DB::table('subscriptions')->insert(array('email'=>$input['email']));

					return 2;		    		

		    	}catch(\Exception $e){
		    		return 1;
		    	}

		    }else{
		    	return 0;
		    }
		}
	}
}