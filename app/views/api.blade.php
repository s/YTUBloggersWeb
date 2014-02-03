@extends('layouts.master')

@section('content')    
    <div class="starter-template">
        <h3>Are you a developer?</h3>
        <p class="lead">You can create an app.</p>
    </div>

    <div class="alert alert-info col-md-8 col-md-offset-2">
        Tip: Looking for documentation? Here you go: <a href="/doc"> Api Documentation.</a>
    </div>
    
    <form class="form-horizontal col-md-8 col-md-offset-2 well" method="post" action="/api" id="apiForm" style="text-align:center;">
    
        @if($errors->has())
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger">{{$error}}</div>
            @endforeach
        @endif

        @if(isset($url))
            <div class="alert alert-success">
                Your client token: {{$token}}
                <div class="clearfix"></div>
                Example request url: <a href="{{$url}}" target="_blank">{{$url}}</a>
            </div>
        @endif
        


        <fieldset>

        <!-- Form Name -->
        <legend>Create your application</legend>        

        <!-- Text input-->
        <div class="control-group">
            <label class="control-label col-xs-3" for="url">Choose a Client ID:</label>
            <div class="controls col-xs-9">
                <input id="url" name="client_id" type="text" placeholder="Client ID" class="input-medium form-control" required="" value="{{Input::old('client_id')}}">
                <p class="help-block">Your application id.(Eg: MyAwesomeApplication)</p>
            </div>
        </div>

        <div class="clearfix"></div>

        <!-- Text input-->
        <div class="control-group">
            <label class="control-label col-xs-3" for="email">Your E-Mail:</label>
            <div class="controls col-xs-9">
                <input id="email" name="email" type="text" placeholder="Your E-Mail" class="input-medium form-control" required="" value="{{Input::old('email')}}">
                <p class="help-block">Your E-mail id.(Eg: foo@bar.com)</p>
            </div>
        </div>


        <div class="clearfix"></div>

        <!-- Button -->
        <div class="control-group">
            <label class="control-label" for="singlebutton"></label>

            <div class="controls">
                <div class="col-xs-12">
                    <button id="singlebutton" href="#fakelink" class="btn btn-block btn-lg btn-inverse addme_button">Create application</button>
                </div>                
            </div>
        </div>

        </fieldset>
    </form>

@stop
