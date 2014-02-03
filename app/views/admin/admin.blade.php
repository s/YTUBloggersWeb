@extends('layouts.master')

@section('content')
	<h4>This is dashboard of network.</h4>
	<hr/>
	<h6>#There are {{$blog_count}} blogs grabbed so far.</h6>
	<h6>#There are <a href="/adminlist">{{$admin_users_count}} admins</a> in system. </h6>
		<h6 style="margin-left:5%;" class="italic">
			<a href="/addnewadmin">
				Add new admin
			</a>
		</h6>
	<h6>#There are <a href="/userlist">{{$blogger_count}} users</a> in system. </h6>
@stop