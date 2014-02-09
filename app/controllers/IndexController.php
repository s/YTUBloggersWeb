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

		$order = Input::get('order');

		if($order){
			$splitted = explode('_', $order);

			$asc = $splitted[1];

			$filter = $splitted[0];
		
			if ('alpha' == $filter) {
				$whole_data = Data::orderBy('post_title',$asc)->paginate('6');
			}else if ('recent' == $filter) {
				$whole_data = Data::orderBy('post_created_at',$asc)->paginate('6');
			}else if ('view' == $filter) {
				$whole_data = Data::orderBy('post_view_count',$asc)->paginate('6');
			}
		}else{
			$whole_data = Data::orderBy('post_created_at','desc')->paginate('6');
		}		

		$this->layout->content = View::make('index',array('order'=>$order,'host' => Config::get('constants.host'),'whole_data'=>$whole_data,'colors'=>Config::get('constants.colors')));
	}

	public function submit(){	

		if(Request::is_post()){
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

							$data['from']['address'] = 'help@ytubloggers.com';

							$data['from']['name'] = 'YTUBloggers';

							Mail::send('emails.welcome', $data, function($message)
							{
								$message->from('help@ytubloggers.com','YTUBloggers');
							    $message->to(Input::get('email'))->subject('Welcome!');
							});

							return Redirect::to('submit')->withErrors(array('message'=>'Now you are one of us :). Happy blogging!'));

						}else{
							return Redirect::to('submit')->withErrors(array('message'=>'An error occured.'));
						}
					
					}catch(\Exception $e){

						//print_r($e->getMessage());exit;
						
						Input::flash();

						return Redirect::to('submit')->withErrors(array('message'=>'An error occured.'));
					} 
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
				print_r($value);
				print_r($e->getMessage());
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

			print_r($feed);
			
			print_r($e->getMessage());

		}
		
	}

	public function insert_one_feed($object,$latest_post_date,$user_id){
		
		if(property_exists($object, 'channel')){			
				
			$insert['blog_title'] = (string)$object->channel->title;			

			foreach($object->channel->item as $key => $value){
				
				$date = strtotime((string)$value->pubDate);				
					
				$insert['post_url'] = (string)$value->link;
				
				$insert['post_content'] = (string)$value->description;

				$insert['post_title'] = (string)$value->title;
			
				$insert['post_created_at'] = date('Y-m-d H:i:s',$date);

				$insert['user_id'] = $user_id;				

				if($latest_post_date < $date){
					
					$slug = $this->slug((string)$insert['post_title']);
			
					$count = DB::table('data')->where('slug','LIKE',$slug.'%')->count();

					if($count>=1)
						$slug = $slug.'-'.($count+1);
					
					$insert['slug'] = $slug;

					DB::table('data')->insert($insert);

					$this->tweet($insert);
				
				}else{

					if (isset($insert['slug'])) {
						unset($insert['slug']);
					}

					DB::table('data')->where('post_url',$insert['post_url'])->update($insert);

				}
				
			}
		}else if(property_exists($object, 'entry')){

			$insert['blog_title'] = (string)$object->title;			
		
			foreach($object->entry as $key => $value){

				$date = strtotime((string)$value->published);
				
				$link = (array)$value->link;
					
				$insert['post_url'] = (string)$link['@attributes']['href'];
				
				$insert['post_content'] = (string)mb_substr($value->content, 0, 600);

				$insert['post_title'] = (string)$value->title;
				
				$insert['post_created_at'] = date('Y-m-d H:i:s',$date);

				$insert['user_id'] = $user_id;		

				try{
					if($latest_post_date < $date){

						$slug = $this->slug((string)$insert['post_title']);

						$count = DB::table('data')->where('slug','LIKE',$slug.'%')->count();			

						if($count>=1)
							$slug = $slug.'-'.($count+1);
						
						$insert['slug'] = $slug;
						
						DB::table('data')->insert($insert);

						$this->tweet($insert);

					}else{
						if (isset($insert['slug'])) {
							unset($insert['slug']);
						}

						DB::table('data')->where('post_url',(string)$link['@attributes']['href'])->update($insert);	
					}
				}catch(\Exception $e){
					//print_r($e->getTrace());exit;
				}
			}
		}

		//$this->tweet($insert);		
	}
	public function community(){
		$whole_data = Users::where('status','1')->paginate('8');		

		$this->layout->content = View::make('community',array('whole_data'=>$whole_data,'colors'=>Config::get('constants.colors')));
	}
	public function api(){		

		if(Request::is_post()){
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
			    		try{
							if(DB::table('clients')->insert(Input::all())){

								$url = Config::get('constants.api_host_with_port');

								$url = $url.'/v1/get?client_id='.Input::get('client_id').'&client_token='.$client_token.'&limit=5';

								$token = $client_token;						

								try{
								
									$view_data['token'] = $token;

									$view_data['title'] = 'Your Application is created.';

									$view_data['description'] = 'Your Application '. Input::get('name'). ' is now registered.';

									$view_data['url'] = $url;							

									Mail::send('emails.welcome_api', $view_data, function($message)
									{
										$message->from('ytubloggers@gmail.com','YTUBloggers');
									    $message->to(Input::get('email'))->subject('Welcome!');
									});							

									return View::make('api')->with('url',$url)->with('token',$client_token)->withErrors(array('message'=>'You\'ve registered your application. An email has been sent to you.'));

								}catch(\Exception $e){
									Input::flash();
									
									return Redirect::to('api')->withErrors(array('message'=>'An error occured.'));
								}						

							}else{	
								Input::flash();
								return Redirect::to('api')->withErrors(array('message'=>'An error occured.'));
							}
						}catch(\Exception $e){
							Input::flash();
							
						}
					
					}catch(\Exception $e){
						
						Input::flash();

						return Redirect::to('api')->withErrors(array('message'=>'An error occured.'));
					} 
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

		$subscribe = Helpers::subscribe(Input::all());

		if(0 == $subscribe){
			return Redirect::to('/')->withErrors(array('message'=>'Please enter all the required blanks.'));
		}else if( 1 == $subscribe){
			return Redirect::to('/')->withErrors(array('message'=>'An error occured.'));
		}else if( 2 == $subscribe){
			return Redirect::to('/')->withErrors(array('message'=>'You will get weekly newsletter :)'));
		}

	}

	public function permalink($slug){

		try{
			$page = DB::table('data')->where('slug', '=', $slug)->first();
			
			if(!sizeof($page)){
				return Redirect::to(Config::get('constants.host_with_port'));	
			}else{
				Data::where('slug','=',$slug)->first()->increment('post_view_count');
			}

		}catch(\Exception $e){	    	
	    	return Redirect::to(Config::get('constants.host_with_port'));
	    }

	    return View::make('permalink', array('host' => Config::get('constants.host'),'whole_data' => $page,'colors' => Config::get('constants.colors')));
	}
	public function fix(){

		$data = DB::table('data')->get();

		foreach ($data as $key => $value) {

			$slug = $this->slug($value->post_title);
			
			$count = DB::table('data')->where('slug','LIKE',$slug.'%')->count();

			echo $slug."<br/>";

			if($count>=1)
				$slug = $slug.'-'.($count+1);


			DB::table('data')->where('id',$value->id)->update(array('slug'=>$slug));
		}
		exit;
	}

	public function slug($value)
	{  	
		
		$value = str_replace("ç", 'c', $value);
		$value = str_replace("ö", 'o', $value);
		$value = str_replace("ğ", 'g', $value);
		$value = str_replace("ş", 's', $value);
		$value = str_replace("ü", 'u', $value);
		$value = str_replace("Ç", 'C', $value);
		$value = str_replace("Ö", 'O', $value);
		$value = str_replace("Ğ", 'G', $value);
		$value = str_replace("Ş", 'S', $value);
		$value = str_replace("Ü", 'U', $value);
		$value = str_replace("İ", 'i', $value);
		$value = str_replace("ı", 'i', $value);

	    $value = str_replace("@", ' at ', $value);
	    $value = str_replace("&", ' and ', $value);
	    $value = str_replace("£", ' pound ', $value);
	    $value = str_replace("#", ' hash ', $value);
	    $value = preg_replace("/[\-+]/", ' ', $value);
	    $value = preg_replace("/[\s+]/", ' ', $value);
	    $value = preg_replace("/[\.+]/", '.', $value);
	    $value = preg_replace("/[^A-Za-z0-9\.\s]/", '', $value);
	    $value = preg_replace("/[\s]/", '-', $value);
	    $value = preg_replace("/\-\-+/", '-', $value);

	    $value = strtolower($value);

	    if (substr($value, -1) == "-") { $value = substr($value, 0, -1); }
	    if (substr($value, 0, 1) == "-") { $value = substr($value, 1); }

	    return $value;
	}

	public function search(){

		$q = Input::get('q');
		
		if (strlen($q)) {
			
			$whole_data = Data::where('status','=','1')->where('post_title', 'LIKE', "%$q%")->orderBy('post_created_at','desc')->paginate('8');			
			
			$whole_data->setBaseUrl('search');			
			
			$this->layout->content = View::make('search',array('host' => Config::get('constants.host'),'q'=>$q,'whole_data'=>$whole_data,'colors'=>Config::get('constants.colors')));

		}else{
			return Redirect::to(Config::get('constants.host_with_port'));
		}
		
	}

	public function weeklynewsletter(){
		$token = Input::get('token');

		if(isset($token) && 'OzA.s187ajMQa.OqFggH' == $token){
			
			$posts = Data::where('status','1')->take(3)->get();
		}

		exit;
	}

	public function postalltweets(){
		$posts = Data::where('status','1')->get();
		
		foreach ($posts as $key => $value) {
			$tweet = '';			

			$tweet.= 'http://ytubloggers.com/'.$value->slug.' on YTUBloggers Network';

			$kalan = 140 - 45;

			$tweet = mb_substr($value->post_title,0,$kalan-4).'... '.$tweet;

			echo $tweet.'<br/>';

			echo Twitter::postTweet(array('status' => $tweet, 'format' => 'json'));
			exit;
			//sleep(10);			
		}
		exit;
	}

	public function tweet($insert){
		$tweet = '';			

		$tweet.= Config::get('constants.host').'/'.$insert->slug.' on YTUBloggers Network';

		$kalan = 140 - 45;

		$tweet = mb_substr($insert->post_title,0,$kalan-4).'... '.$tweet;
		
		Twitter::postTweet(array('status' => $tweet, 'format' => 'json'));
	}
}