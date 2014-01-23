@extends('layouts.master')

@section('content')
	
	<div class="starter-template">
        <h3>Who is already here?</h3>
    </div>

	<div class="container">
		<?php $i=0; ?>
		<div class="col-md-6 col-md-push-3">
			@if(sizeof($whole_data))
				@foreach ($whole_data as $d)
					<div class="col-xs-2 post_date">
						<a target="_blank" class="noa" href="{{$d->post_url}}">
							{{date('d',strtotime($d->created_at))}}
							<div class="clearfix"></div>
							{{substr(date('F',strtotime($d->created_at)),0,3)}}
							<div class="clearfix"></div>
							{{date('Y',strtotime($d->created_at))}}
						</a>
		    		</div>
					<blockquote class="col-xs-8 user_block">
		    			<p>
		    				<i class="fa fa-anchor"></i>
		    				<a href="{{$d->url}}" target="_blank">{{$d->url}}</a>
		    			</p>
		    			<p>
		    				<i class="fa fa-envelope"></i>
		    				<a href="mailto:{{$d->email}}">
		    					{{$d->email}}
		    				</a>
		    			</p>		    			
		    		</blockquote>
		    		<div class="clearfix"></div>
			    @endforeach
			@else
				<div class="alert alert-info">
					There is nobody yet :(
				</div>
			@endif
		</div>
	    <div class="clearfix"></div>
	    <div class="col-md-6 col-md-push-5">
	    	<?php echo $whole_data->links(); ?>
	    </div>
		
	</div>
@stop