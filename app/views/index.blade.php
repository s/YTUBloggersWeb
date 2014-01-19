@extends('layouts.master')
	
@section('content')
	<div class="starter-template">
        <h1>Welcome to the YTU-CE Blogging Network</h1>
        <p class="lead">You can see most recent blogs here.</p>
    </div>

	<div class="container">
		<div class="row">		
			<div class="col-md-8 col-md-push-2">
				@if(sizeof($whole_data))
		    		@foreach ($whole_data as $d)
		    		<div class="well">
		    			<div class="col-md-8">
		    				<span class="label label-success pull-left post-upper-left">
		    					<i class="fa fa-user"></i>
		    					<a href="{{$d->post_url}}" target="_blank" class="noa">
		    						{{$d->blog_title}}
		    					</a>
		    				</span>
		    				<div class="pull-left" style="margin-left:20px;">
		    					<h5>
		    						<a href="{{$d->post_url}}" class="noa" target="_blank">
		    							@if(strlen($d->post_title)>50)
		    								{{mb_substr($d->post_title,0,30)}}...
		    							@else
		    								{{$d->post_title}}
		    							@endif
		    						</a>
		    					</h5>
		    				</div>
		    			</div>
		    			<div class="col-md-4 pull-right "  style="text-align:right;">
		    				<p style="margin-top:10px;">
		    					<i class="fa fa-clock-o"></i>
		    					<a target="_blank" class="noa" href="{{$d->post_url}}">
		    						{{date('d F Y',strtotime($d->post_created_at))}}
		    					</a>
		    				</p>
		    			</div>
		    			<div class="clearfix"></div>
		    			<div class="col-md-12">	
		    				<p style="font-style:italic !important;">{{strip_tags($d->post_content)}}</p>
		    				<a href="{{$d->post_url}}" target="_blank">
		    					Read More on {{$d->blog_title}}
		    				</a>
		    			</div>
		    			<div class="clearfix"></div>
		    		</div>	        	
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