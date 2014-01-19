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
		$whole_data = Data::orderBy('post_created_at','desc')->paginate('5');

		$this->layout->content = View::make('index')->with('whole_data', $whole_data);
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

						return Redirect::to('submit')->withErrors(array("message"=>"Now you are one of us :). Happy blogging!"));

					}else{
						return Redirect::to('submit')->withErrors(array("message"=>"An error occured."));
					}
				
				}catch(\Exception $e){
					
					Input::flash();

					return Redirect::to('submit')->withErrors(array("message"=>"An error occured."));
				} 
		    }
		}
		$this->layout->content = View::make('submit');
	}

	public function grabber(){

		$token = Input::get('token');

		if(isset($token) && 'blah blah' == $token){

			$users = DB::table('users')->get();

			//print_r($value);
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
		$whole_data = User::paginate('10');

		$this->layout->content = View::make('community')->with('whole_data', $whole_data);
	}
}
