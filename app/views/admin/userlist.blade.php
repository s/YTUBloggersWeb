@extends('layouts.master')

@section('content')
	
	<div class="starter-template">
        <h6 class="pull-left" style="text-decoration:underline;">User List</h6>
    </div>

	<div class="container">				
		<div class="col-md-12">
			@if($errors->has())
	            @foreach ($errors->all() as $error)
	                <div class="alert alert-danger">{{$error}}</div>        
	            @endforeach
        	@endif
			@if(sizeof($users))
				<table class="table pull-left">
					<thead>
						<tr>
							<th>#</th>
							<th>url</th>
							<th>email</th>
							<th>created</th>
							<th>status</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($users as $d)
							<tr>
								<td>{{$d->id}}</td>
								<td>{{$d->url}}</td>
								<td>{{$d->email}}</td>
								<td>{{$d->created_at}}</td>
								<td>
									<a href="/changeuserstatus?id={{$d->id}}&set={{$d->status == 1 ? 0 : 1}}&type=user">
										{{$d->status == 1 ? 'Active' : 'Passive'}}
									</a>
								</td>
							</tr>
					    @endforeach
					</tbody>
				</table>
			@else
				<div class="alert alert-info">
					
				</div>
			@endif
		</div>
	    <div class="clearfix"></div>
	    <div class="col-md-7 col-md-push-4">
	    	<?php echo $users->links(); ?>
	    </div>
		
	</div>
@stop