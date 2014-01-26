@extends('layouts.master')

@section('content')
    <form class="form-horizontal well loginForm col-md-6 col-md-push-3" id="loginForm" method="post" action="/login">        
        @if($errors->has())
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger">{{$error}}</div>        
            @endforeach
        @endif
        
        <fieldset>


        <!-- Form Name -->
        <legend>Login</legend>

        <!-- Text input-->


        <div class="control-group">
          <label class="control-label pull-left" for="username">Username:</label>
          <div class="controls col-md-10">
            <input id="username" name="username" type="text" placeholder="Username" class="input-xlarge form-control pull-left">            
          </div>
        </div>

        <div class="clearfix" style="margin-bottom:20px;"></div>

        <!-- Password input-->
        <div class="control-group">
          <label class="control-label pull-left" for="password">Password:&nbsp;</label>
          <div class="controls col-md-10">
            <input id="password" name="password" type="password" placeholder="Password" class="input-xlarge form-control">
          </div>
        </div>

        <div class="clearfix" style="margin-bottom:20px;"></div>

        <!-- Button -->
        <div class="control-group">
          <div class="controls">
            <button  class="btn btn-inverse col-md-12">Login</button>
          </div>
        </div>

        </fieldset>
    </form>

@stop