@extends('layouts.master')
	
@section('content')
	<div class="starter-template">
        <h3>Welcome to the YTU-CE Blogging Network</h3>
        <p class="lead">You can see most recent blogs here.</p>
    </div>

	<div class="container">
		<div class="row">		
			<div class="col-md-11 col-md-push-1">
				@if(sizeof($whole_data))
		    		@foreach ($whole_data as $d)
			    		<div class="col-xs-1 post_date">
							<a target="_blank" class="noa" href="{{$d->post_url}}">
								{{date('d',strtotime($d->post_created_at))}}
								<div class="clearfix"></div>
								{{substr(date('F',strtotime($d->post_created_at)),0,3)}}
								<div class="clearfix"></div>
								{{date('Y',strtotime($d->post_created_at))}}
							</a>
			    		</div>
			    		<blockquote class="col-xs-8">
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
			    					<i class="fa fa-user"></i>
			    					<a href="{{$d->post_url}}" target="_blank" class="noa">
			    						{{$d->blog_title}}
			    					</a>
			    				</div>
			    				
			    			</div>
			    			
			    			<div class="clearfix"></div>
			    			<div class="col-md-12">	
			    				<p class="post_content">{{strip_tags($d->post_content)}}</p>
			    				<a href="{{$d->post_url}}" target="_blank">
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
	    	<div class="col-md-6 col-md-push-4">
	    		<?php echo $whole_data->links(); ?>
	    	</div>
		</div>	
	</div>
@stop