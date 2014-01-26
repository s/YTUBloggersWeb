<?php

class AdminController extends Controller {

	protected $layout = 'admin.layouts.master';

	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}
	public function dashboard(){	

			
		$admin_users_count = DB::table('admin_users')->count();		

		$blog_count = DB::table('data')->count();

		$blogger_count = DB::table('users')->count();

		$this->layout->content = View::make(
			'admin.admin',array(
								'admin_users_count'		=>$admin_users_count,
								'blog_count'			=>$blog_count,
								'blogger_count'			=>$blogger_count,
								));

	}

	public function login(){
		
		$this->layout->content = View::make('admin.login');

		if(sizeof(Input::all())){

			$rules = array(
	        	'username' 		=> array('required'),
	        	'password'		=> array('required')
		    );		    

		    $validation = Validator::make(Input::all(), $rules);

		    if($validation->fails()){
		    	
		    	Input::flash();

		    	return Redirect::to('login')->withErrors($validation->messages())->withInput();

		    }else{

		    	$credentials = array(
		            'username' => Input::get('username'),
		            'password' => Input::get('password')
		        );
						    	
		    	try{
			    	$user = DB::table('admin_users')->where('username',Input::get('username'))->where('status','1')->first();
			    	

			    	if(sizeof($user)){

			    		if($user->password == md5(Input::get('password'))){

			    			Session::set('user',$user);

			    			return Redirect::to('dashboard');

			    		}else{
			    			return Redirect::to('login')->withErrors(array('message'=> 'Wrong username/password combination.'))->withInput();
			    		}

			    	}else{
			    		return Redirect::to('login')->withErrors(array('message'=> 'User not recognized.'))->withInput();
			    	}
			    }catch(\Exception $e){
			    	//print_r($e->getMessage());exit();
			    }
		        		        
		    }	
		}
	}
	public function changeadminstatus(){


		if(sizeof(Input::all())){


			$rules = array(
	        	'id' 		=> array('required'),
	        	'set'		=> array('required')	        	
		    );		    

		    $validation = Validator::make(Input::all(), $rules);

		    if(Input::get('type') == 'admin'){
		    	$url = 'adminlist';
		    	$table = 'admin_users';
		    }
		    else{
		    	$url = 'userlist';
		    	$table = 'users';
		    }

		    if($validation->fails()){
		    	
		    	Input::flash();

		    	return Redirect::to($url)->withErrors($validation->messages());
		    }else{

		    	try{
		    		$update = DB::table($table)->where('id',Input::get('id'))->update(array('status'=>Input::get('set')));
			    	if($update){
			    		return Redirect::to($url)->withErrors(array('message'=> 'Changes saved.'));
			    	}else{
			    		return Redirect::to($url)->withErrors(array('message'=> 'An error occured.'));
			    	}	
		    	}catch(\Exception $e){
		    		print_r($e->getMessage());exit();
		    	}
		    	
		    }
		}
	}

	public function logout(){
		
		if(Session::has('user')){
			Session::forget('user');
		}

    	return Redirect::to('/')->with('flash_notice', 'You are successfully logged out.');
	}

	public function settings(){

		if(sizeof(Input::all())){

			$rules = array(
				'password' 			=> array('required'),
	        	'new_password' 		=> array('required'),
	        	'new_password_again'=> array('required')
		    );		    

		    $validation = Validator::make(Input::all(), $rules);

		    if($validation->fails()){
		    	
		    	Input::flash();

		    	return Redirect::to('settings')->withErrors($validation->messages())->withInput();
		    }else{

		    	if(Input::get('new_password') == Input::get('new_password_again')){

		    		$user = DB::table('admin_users')->where('username',Session::get('user')->username)->first();

		    		if(md5(Input::get('password')) == $user->password){		    			

						if(DB::table('admin_users')->where('username',Session::get('user')->username)->update(array('password'=>md5(Input::get('new_password'))))){

							return Redirect::to('settings')->withErrors(array('message'=> 'Your settings saved.'))->withInput();

						}else{
							return Redirect::to('settings')->withErrors(array('message'=> 'An error occured.'))->withInput();
						}
		    				

		    		}else{
		    			return Redirect::to('settings')->withErrors(array('message'=> 'New Old password is wrong.'))->withInput();
		    		}

		    	}else{
		    		return Redirect::to('settings')->withErrors(array('message'=> 'New Passwords mismatch.'))->withInput();
		    	}
		    }			

		}

		$this->layout->content = View::make('admin.settings');
	}

	public function adminlist(){

		$admins = DB::table('admin_users')->orderBy('created_at','desc')->paginate('8');

		$this->layout->content = View::make('admin.adminlist',array('admins'=>$admins));
	}

	public function userlist(){

		$admins = DB::table('users')->orderBy('created_at','desc')->paginate('8');

		$this->layout->content = View::make('admin.userlist',array('users'=>$admins));
	}
	public function addnewadmin(){
		
		if(sizeof(Input::all())){
			$rules = array(
				'username' 		=> array('required','unique:admin_users,username'),
				'email' 		=> array('required','unique:admin_users,email'),
	        	'password' 		=> array('required')
		    );		    

		    $validation = Validator::make(Input::all(), $rules);

		    if($validation->fails()){
		    	
		    	Input::flash();

		    	return Redirect::to('/addnewadmin')->withErrors($validation->messages())->withInput();
		    }else{
		    	try{
			    	$insert = DB::table('admin_users')->insert(array('email'=>Input::get('email'),'username'=>Input::get('username'),'password'=>md5(Input::get('password'))));

			    	if($insert){
			    		return Redirect::to('/addnewadmin')->withErrors(array('message'=> 'Admin added.'))->withInput();	
			    	}else{
			    		return Redirect::to('/addnewadmin')->withErrors(array('message'=> 'An error occured.'))->withInput();
			    	}
			    }catch(\Exception $e){

			    }
		    }
		}
		$this->layout->content = View::make('admin.addnewadmin');
	}
}