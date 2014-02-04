@extends('layouts.master')
	
@section('content')
	<div class="starter-template">
        <h3>Welcome to the YTU-CE Blogging Network</h3>
        <p class="lead">You can see most recent blogs here.</p>
    </div>

	<div class="container">		
		<div class="row">		
			<div class="col-md-12" style="margin-bottom:50px;">				

				@if(sizeof($whole_data))
						    		
	    			<?php 
	    				$random_color = $colors[rand(0,sizeof($colors)-1)];
	    			?>	
		    		<div class="col-xs-1 post_date" style="color:<?php echo $random_color;?> !important;">
						<a target="_blank" class="noa" href="{{$whole_data->post_url}}">
							{{date('d',strtotime($whole_data->post_created_at))}}
							<div class="clearfix"></div>
							{{substr(date('F',strtotime($whole_data->post_created_at)),0,3)}}
							<div class="clearfix"></div>
							{{date('Y',strtotime($whole_data->post_created_at))}}
						</a>
		    		</div>
		    		<blockquote class="col-xs-10" style="border-color:<?php echo $random_color;?> !important;">
		    			<div class="col-md-12 post_header">
		    				<div class="pull-left post_title">
	    						<a href="{{$whole_data->post_url}}" class="noa" target="_blank">
	    							@if(strlen($whole_data->post_title)>50)
	    								{{mb_substr($whole_data->post_title,0,30)}}...
	    							@else
	    								{{$whole_data->post_title}}
	    							@endif
	    						</a>		    					
		    				</div>
		    				<div class="pull-right ">
		    					<i class="fa fa-user" style="color: <?php echo $random_color; ?> !important;"></i>
		    					<a href="{{$whole_data->post_url}}" target="_blank" class="noa">
		    						{{$whole_data->blog_title}}
		    					</a>
		    				</div>
		    				
		    			</div>
		    			
		    			<div class="clearfix"></div>
		    			<div class="col-md-12">	
		    				<p class="post_content">{{mb_substr(strip_tags($whole_data->post_content),0,1000)}}...</p>
		    				<a href="{{$whole_data->post_url}}" target="_blank" style="color: <?php echo $random_color;?> !important;">
		    					Read More on {{$whole_data->blog_title}}
		    				</a>
		    			</div>
		    			<div class="clearfix"></div>
		    			<div class="col-xs-10">
		    				<div class="col-xs-2">
		    					<div class="fb-share-button" data-href="{{$host.'/'.$whole_data->slug}}" data-type="button_count"></div>
			    			</div>
			    			<div class="col-xs-2" style="margin-top:9px;">
			    				<a href="https://twitter.com/share" class="twitter-share-button" data-via="ytubloggers" data-url="{{$host.'/'.$whole_data->slug}}" data-text="{{$whole_data->post_title}}">Tweet</a>
			    			</div>
		    			</div>
		    		</blockquote>
	    			<div class="clearfix"></div>
		    		
		    	@else
		    		<div class="alert alert-info">
		    			This post is not available :(
		    		</div>
		    	@endif
	    	</div>
	    	<div class="clearfix"></div>	 
		</div>	
	</div>
@stop