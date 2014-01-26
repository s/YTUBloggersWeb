@extends('layouts.master')

@section('content')

    <form class="form-horizontal loginForm col-md-8 col-md-offset-2 well" method="post" action="/addnewadmin" id="addAdminForm" style="text-align:center;">
    
        @if($errors->has())
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger">{{$error}}</div>        
            @endforeach
        @endif

        <fieldset>

        <!-- Form Name -->
        <legend>Add new admin</legend>    

        <!-- Text input-->
        <div class="control-group">
            <label class="control-label col-xs-3" for="username">Username:</label>
            <div class="controls col-xs-9">
                <input id="username" name="username" type="text" placeholder="Username" class="input-medium form-control" required="" value="{{Input::old('username')}}">
                <p class="help-block"></p>
            </div>
        </div>

        <div class="clearfix"></div>

        <!-- Text input-->
        <div class="control-group">
            <label class="control-label col-xs-3" for="email">Email:</label>
            <div class="controls col-xs-9">
                <input id="email" name="email" type="text" placeholder="Email" class="input-medium form-control" required="" value="{{Input::old('username')}}">
                <p class="help-block"></p>
            </div>
        </div>

        <div class="clearfix"></div>

        <!-- Text input-->
        <div class="control-group">
            <label class="control-label col-xs-3" for="password">Password:</label>
            <div class="controls col-xs-9">
                <input id="password" name="password" type="password" placeholder="E-Mail" class="input-medium form-control" required="" value="{{Input::old('email')}}"/>                
                <p class="help-block"></p>
            </div>
        </div>

        <!-- Button -->
        <div class="control-group">
            <label class="control-label" for="singlebutton"></label>

            <div class="controls">
                <div class="col-xs-12">
                    <button id="singlebutton" href="#fakelink" class="btn btn-block btn-lg btn-inverse addme_button">Add</button>
                </div>                
            </div>
        </div>

        </fieldset>
    </form>
@stop