@extends('layouts.master')

@section('content')
	
	<div class="starter-template">
        <h3>Who is already here?</h3>
    </div>

	<div class="container">		
		<?php $i=0; ?>
		<div class="col-md-12">
			@if(sizeof($whole_data)<4)
				<div class="ghost">
					@foreach ($whole_data as $d)
					<?php 
	    				$random_color = $colors[rand(0,sizeof($colors)-1)];
	    			?>
	    			<div class="col-md-6 pull-left">
						<div class="col-xs-2 post_date" style="color:<?php echo $random_color;?> !important;">
							<a target="_blank" class="noa" href="{{$d->post_url}}">
								{{date('d',strtotime($d->created_at))}}
								<div class="clearfix"></div>
								{{substr(date('F',strtotime($d->created_at)),0,3)}}
								<div class="clearfix"></div>
								{{date('Y',strtotime($d->created_at))}}
							</a>
			    		</div>
						<blockquote class="col-xs-8 user_block" style="border-color:<?php echo $random_color;?> !important;color:<?php echo $random_color;?> !important;">
			    			<p>
			    				<i class="fa fa-anchor"></i>
			    				<a href="{{$d->url}}" target="_blank" style="color:<?php echo $random_color;?> !important;">{{$d->url}}</a>
			    			</p>
			    			<p>
			    				<i class="fa fa-envelope"></i>
			    				<a href="mailto:{{$d->email}}" style="color:<?php echo $random_color;?> !important;">
			    					{{$d->email}}
			    				</a>
			    			</p>		    			
			    		</blockquote>
			    	</div>
			    	@endforeach
			    </div>
			@elseif(sizeof($whole_data))
				@foreach ($whole_data as $d)
					<?php 
	    				$random_color = $colors[rand(0,sizeof($colors)-1)];
	    			?>
	    			<div class="col-md-6 pull-left">
						<div class="col-xs-2 post_date" style="color:<?php echo $random_color;?> !important;">
							<a target="_blank" class="noa" href="{{$d->post_url}}">
								{{date('d',strtotime($d->created_at))}}
								<div class="clearfix"></div>
								{{substr(date('F',strtotime($d->created_at)),0,3)}}
								<div class="clearfix"></div>
								{{date('Y',strtotime($d->created_at))}}
							</a>
			    		</div>
						<blockquote class="col-xs-8 user_block" style="border-color:<?php echo $random_color;?> !important;color:<?php echo $random_color;?> !important;">
			    			<p>
			    				<i class="fa fa-anchor"></i>
			    				<a href="{{$d->url}}" target="_blank" style="color:<?php echo $random_color;?> !important;">{{$d->url}}</a>
			    			</p>
			    			<p>
			    				<i class="fa fa-envelope"></i>
			    				<a href="mailto:{{$d->email}}" style="color:<?php echo $random_color;?> !important;">
			    					{{$d->email}}
			    				</a>
			    			</p>		    			
			    		</blockquote>
			    	</div>
			    @endforeach
			@else
				<div class="alert alert-info">
					There is nobody yet :(
				</div>
			@endif
		</div>
	    <div class="clearfix"></div>
	    <div class="col-md-7 col-md-push-4">
	    	<?php echo $whole_data->links(); ?>
	    </div>
		
	</div>
@stop