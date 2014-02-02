@extends('layouts.master')
	
@section('content')
	<div class="starter-template">
        <h3>Welcome to the YTU-CE Blogging Network</h3>
        <p class="lead">You can see most recent blogs here.</p>
    </div>

	<div class="container">
		<div class="row">
			<div class="col-md-6 col-md-push-3">
				@if($errors->has())
			        @foreach ($errors->all() as $error)
			            <div class="alert alert-info">{{$error}}</div>        
			        @endforeach
			    @endif
			</div>
		</div>
		<div class="row">			
			<div class="col-md-8 col-md-push-1">
				<label for="filter" class="pull-left" style="font-size:20px;margin-top:-2px;">Filter:</label>
				<select name="filter" id="filter" class="col-md-8 pull-left" onchange="location = this.options[this.selectedIndex].value;">
					<option value="">Choose</option>
					<option value="{{URL::to('/')}}?order=alpha_asc" {{$order == 'alpha_asc' ? 'selected' : '';}}>Alphabetic</option>
					<option value="{{URL::to('/')}}?order=alpha_desc" {{$order == 'alpha_desc' ? 'selected' : '';}}>Reverse Alphabetic</option>
					<option value="{{URL::to('/')}}?order=recent_asc" {{$order == 'recent_asc' ? 'selected' : '';}}>Least Recent</option>
					<option value="{{URL::to('/')}}?order=recent_desc" {{$order == 'recent_desc' ? 'selected' : '';}}>Most Recent</option>
					<option value="{{URL::to('/')}}?order=view_asc" {{$order == 'view_asc' ? 'selected' : '';}}>Least Viewed</option>
					<option value="{{URL::to('/')}}?order=view_desc" {{$order == 'view_desc' ? 'selected' : '';}}>Most Viewed</option>
				</select>
			</div>			
			<div class="clearfix"></div>
			<hr/>
			<div class="col-md-12">				

				@if(sizeof($whole_data))
					
		    		@foreach ($whole_data as $d)
		    			<?php 
		    				$random_color = $colors[rand(0,sizeof($colors)-1)];
		    			?>	
			    		<div class="col-xs-1 post_date" style="color:<?php echo $random_color;?> !important;">
							<a target="_blank" class="noa" href="{{$d->post_url}}">
								{{date('d',strtotime($d->post_created_at))}}
								<div class="clearfix"></div>
								{{substr(date('F',strtotime($d->post_created_at)),0,3)}}
								<div class="clearfix"></div>
								{{date('Y',strtotime($d->post_created_at))}}
							</a>
			    		</div>
			    		<blockquote class="col-xs-10" style="border-color:<?php echo $random_color;?> !important;">
			    			<div class="col-md-12 post_header">
			    				<div class="pull-left post_title">
		    						<a href="{{$d->post_url}}" class="noa" target="_blank">
		    							@if(strlen($d->post_title)>50)
		    								{{mb_substr($d->post_title,0,30)}}...
		    							@else
		    								{{$d->post_title}}
		    							@endif
		    						</a>		    					
			    				</div>
			    				<div class="pull-right ">
			    					<i class="fa fa-user" style="color: <?php echo $random_color; ?> !important;"></i>
			    					<a href="{{$d->post_url}}" target="_blank" class="noa">
			    						{{$d->blog_title}}
			    					</a>
			    				</div>
			    				
			    			</div>
			    			
			    			<div class="clearfix"></div>
			    			<div class="col-md-12">	
			    				<p class="post_content">{{mb_substr(strip_tags($d->post_content),0,1000)}}...</p>
			    				<a href="{{$d->post_url}}" target="_blank" style="color: <?php echo $random_color;?> !important;">
			    					Read More on {{$d->blog_title}}
			    				</a>
			    			</div>
			    			<div class="clearfix"></div>
			    			<div class="col-xs-10">
			    				<div class="col-xs-2">
			    					<div class="fb-share-button" data-href="{{$host.'/'.$d->slug}}" data-type="button_count"></div>
				    			</div>
				    			<div class="col-xs-2" style="margin-top:9px;">
				    				<a href="https://twitter.com/share" class="twitter-share-button" data-via="ytubloggers" data-url="{{$host.'/'.$d->slug}}" data-text="{{$d->post_title}}">Tweet</a>
				    			</div>
			    			</div>
			    		</blockquote>			    		
		    			<div class="clearfix"></div>		    			
		    		@endforeach
		    	@else
		    		<div class="ghost">
		    			Nobody has posted yet :(
		    		</div>
		    	@endif
	    	</div>
	    	<div class="clearfix"></div>
	    	<div class="col-md-9 col-md-push-3">
	    		<?php echo $whole_data->appends(array('order'=>$order))->links(); ?>
	    	</div>
		</div>	
	</div>
@stop