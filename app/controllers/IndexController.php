<?php

class IndexController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	protected $layout = 'layouts.master';

	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

	public function index()
	{

		
		$whole_data = Data::orderBy('post_created_at','desc')->paginate('8');

		$this->layout->content = View::make('index',array('whole_data'=>$whole_data,'colors'=>Config::get('constants.colors')));
	}

	public function submit(){		

		if(sizeof(Input::all())){
			
			$rules = array(
	        	'url' 		=> array('required','unique:users,url'),	        	
	        	'email'		=> array('required','unique:users,email')
		    );		    

		    $validation = Validator::make(Input::all(), $rules);

		    if($validation->fails()){
		    	
		    	Input::flash();

		    	return Redirect::to('submit')->withErrors($validation->messages())->withInput();

		    }else{

		    	try {

					if($id = DB::table('users')->insertGetId(Input::all())){

						DB::table('checks')->insert(array('user_id'=>$id));						

						return Redirect::to('submit')->withErrors(array('message'=>'Now you are one of us :). Happy blogging!'));

					}else{
						return Redirect::to('submit')->withErrors(array('message'=>'An error occured.'));
					}
				
				}catch(\Exception $e){
					
					Input::flash();

					return Redirect::to('submit')->withErrors(array('message'=>'An error occured.'));
				} 
		    }
		}
		$this->layout->content = View::make('submit');
	}

	public function grabber(){

		$token = Input::get('token');

		if(isset($token) && 'OzA.s187ajMQa.OqFggH' == $token){

			$users = DB::table('users')->where('status','1')->get();

			try{
				foreach ($users as $key => $value) {				

					$check = DB::table('checks')->where('user_id', $value->id)->first();

					$this->get_one_feed($value->url, strtotime($check->last_post), $value->id);

					$latest = DB::table('data')->where('user_id',$value->id)->orderBy('post_created_at','desc')->pluck('post_created_at');

					DB::table('checks')->where('user_id',$value->id)->update(array('last_post'=>$latest));
				
				}
			}catch(\Exception $e){
				print_r($e->getMessage());exit();
			}
		}
		exit();
	}

	public function get_one_feed($url, $latest_post_date, $user_id){
	
		try{		
			
			$feed = @file_get_contents($url);

			$rss = new SimpleXmlElement($feed);
			
			$this->insert_one_feed($rss,$latest_post_date, $user_id);

		}catch(\Exception $e){
			
			print_r($e->getMessage());

		}
		
	}

	public function insert_one_feed($object,$latest_post_date,$user_id){
		
		if(property_exists($object, 'channel')){			
				
			$insert['blog_title'] = (string)$object->channel->title;			

			foreach($object->channel->item as $key => $value){
				
				$date = strtotime((string)$value->pubDate);				
				
				if($latest_post_date < $date){					
					
					$insert['post_url'] = (string)$value->link;
				
					$insert['post_content'] = (string)$value->description;

					$insert['post_title'] = (string)$value->title;
				
					$insert['post_created_at'] = date('Y-m-d H:i:s',$date);

					$insert['user_id'] = $user_id;					
				
					DB::table('data')->insert($insert);
				}
				
			}
		}else if(property_exists($object, 'entry')){

			$insert['blog_title'] = (string)$object->title;			
		
			foreach($object->entry as $key => $value){

				$date = strtotime((string)$value->published);
				
				if($latest_post_date < $date){

					$link = (array)$value->link;
					
					$insert['post_url'] = (string)$link['@attributes']['href'];
					
					$insert['post_content'] = (string)mb_substr($value->content, 0, 600);

					$insert['post_title'] = (string)$value->title;
					
					$insert['post_created_at'] = date('Y-m-d H:i:s',$date);

					$insert['user_id'] = $user_id;					
					
					DB::table('data')->insert($insert);
				}
			}
		}
	}
	public function community(){
		$whole_data = User::paginate('7');

		$this->layout->content = View::make('community',array('whole_data'=>$whole_data,'colors'=>Config::get('constants.colors')));
	}
	public function api(){		

		if(sizeof(Input::all())){
			
			$rules = array(
	        	'client_id' => array('required','unique:clients,client_id'),
	        	'email' => array('required','unique:clients,email')
		    );		    

		    $validation = Validator::make(Input::all(), $rules);

		    if($validation->fails()){
		    	
		    	Input::flash();

		    	return Redirect::to('api')->withErrors($validation->messages())->withInput();

		    }else{

		    	try {
		    			
		    		$client_token = uniqid();

		    		Input::merge(array(
		    						'client_token'=>$client_token,
		    						'rate_limit'=>Config::get('constants.rate_limit')		    						
		    						)
		    					);
		    		
					if(DB::table('clients')->insert(Input::all())){

						$url = Config::get('constants.api_host_with_port');

						$url = $url.'/get?client_id='.Input::get('client_id').'&client_token='.$client_token.'&limit=5';

						$token = $client_token;

						$data = array(
						    'name'=>'sfa', 
						    'email'=>'asfa', 
						    'message'=>'asfa'
						);

						try{
						
							Mail::send('emails.welcome', $data, function($message)
							{
								$message->from('said@ozcan.co', 'Laravel');
						    	$message->to('saidozcn@gmail.com', 'John Smith')->subject('Welcome!');
							});							

							return View::make('api')->with('url',$url)->with('token',$client_token)->withErrors(array('message'=>'You\'ve registered your application. An email has been sent to you.'));

						}catch(\Exception $e){
							return Redirect::to('api')->withErrors(array('message'=>'An error occured.'));
						}						

					}else{	

						return Redirect::to('api')->withErrors(array('message'=>'An error occured.'));
					}
				
				}catch(\Exception $e){
					print_r($e->getMessage());exit();
					Input::flash();

					return Redirect::to('api')->withErrors(array('message'=>'An error occured.'));
				} 
		    }
		}
		$this->layout->content = View::make('api');
	}	

	public function doc(){
		$this->layout->content = View::make('doc')->with('api_host', Config::get('constants.api_host_with_port'));
	}
	public function rss(){

		$this->layout = null;		

	    // creating rss feed with our most recent 20 posts
	    $posts = DB::table('data')->orderBy('post_created_at', 'desc')->take(20)->get();

	    $feed = Feed::make();

	    // set your feed's title, description, link, pubdate and language
	    $feed->title = 'YTU Blogger Network';
	    $feed->description = 'YTU Blogger Network';
	    $feed->logo = 'http://www.yildiz.edu.tr/images/images/Yildiz_Logo.jpg';
	    $feed->link = URL::to('rss');
	    $feed->pubdate = $posts[0]->post_created_at;
	    $feed->lang = 'en';

	    foreach ($posts as $post)
	    {
	        // set item's title, author, url, pubdate and description
	        $feed->add($post->post_title, $post->blog_title, htmlspecialchars($post->post_url), $post->post_created_at, $post->post_content);
	    }

	    // show your feed (options: 'atom' (recommended) or 'rss')
	    return $feed->render('atom');
	}

	public function newsletter(){

		if(sizeof(Input::all())){
			
			$rules = array(	        	
	        	'email'		=> array('required','unique:subscriptions,email')
		    );		    

		    $validation = Validator::make(Input::all(), $rules);

		    if(!$validation->fails()){

		    	try{
		    		$insert = DB::table('subscriptions')->insert(array('email'=>Input::get('email')));

		    		return Redirect::to('/')->withErrors(array('message'=>'You will get weekly newsletter :)'));

		    	}catch(\Exception $e){
		    		
		    	}

		    }

		    return Redirect::to('/');
		}	
	}
}