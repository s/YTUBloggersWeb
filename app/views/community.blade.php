@extends('layouts.master')

@section('content')
	
	<div class="starter-template">
        <h1>Who is already here?</h1>        
    </div>

	<div class="container">
		<?php $i=0; ?>
		<div class="col-md-6 col-md-push-3">
			@if(sizeof($whole_data))
				@foreach ($whole_data as $d)
					<div class="well">
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
		    			<p><i class="fa fa-clock-o"></i> {{date('d F Y',strtotime($d->created_at))}}</p>
		    		</div>
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