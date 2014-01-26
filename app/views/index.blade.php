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
			    		</blockquote>
		    			<div class="clearfix"></div>
		    		@endforeach
		    	@else
		    		<div class="alert alert-info">
		    			Nobody has posted yet :(
		    		</div>
		    	@endif
	    	</div>
	    	<div class="clearfix"></div>
	    	<div class="col-md-9 col-md-push-3">
	    		<?php echo $whole_data->links(); ?>
	    	</div>
		</div>	
	</div>
@stop