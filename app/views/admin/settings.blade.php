@extends('layouts.master')

@section('content')
    <form class="form-horizontal well loginForm col-md-7 col-md-push-2" id="settingsForm" method="post" action="/settings">        
        @if($errors->has())
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger">{{$error}}</div>        
            @endforeach
        @endif
        
        <fieldset>


        <!-- Form Name -->
        <legend>Change your password</legend>

        <!-- Text input-->

        <!-- Password input-->
        <div class="control-group">
          <label class="control-label pull-left" for="password">Old Password:&nbsp;</label>
          <div class="controls col-md-9 pull-right">
            <input id="password" name="password" type="password" placeholder="Password" class="input-xlarge form-control">
          </div>
        </div>

        <div class="clearfix" style="margin-bottom:20px;"></div>

        <!-- Password input-->
        <div class="control-group">
          <label class="control-label pull-left" for="new_password">New Password:&nbsp;</label>
          <div class="controls col-md-9 pull-right">
            <input id="new_password" name="new_password" type="password" placeholder="New Password" class="input-xlarge form-control">
          </div>
        </div>

        <div class="clearfix" style="margin-bottom:20px;"></div>

        <!-- Password input-->
        <div class="control-group">
          <label class="control-label pull-left" for="new_password_again">New Password Again:&nbsp;</label>
          <div class="controls col-md-9 pull-right">
            <input id="new_password_again" name="new_password_again" type="password" placeholder="New Password Again" class="input-xlarge form-control">
          </div>
        </div>

        <div class="clearfix" style="margin-bottom:20px;"></div>

        <!-- Button -->
        <div class="control-group">
          <div class="controls">
            <button type="submit" class="btn btn-inverse col-md-12">Update</button>
          </div>
        </div>

        </fieldset>
    </form>

@stop