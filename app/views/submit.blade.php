@extends('layouts.master')

@section('content')

    <div class="starter-template">
        <h1>Are you a blogger?</h1>
        <p class="lead">You should join us.</p>
    </div>
    
    <form class="form-horizontal col-md-4 col-md-offset-4 well" method="post" action="/submit" id="submitForm" style="text-align:center;">
    
        @if($errors->has())
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger">{{$error}}</div>        
            @endforeach
        @endif

        <fieldset>

        <!-- Form Name -->
        <legend>Submit Your Blog</legend>    

        <!-- Text input-->
        <div class="control-group">
            <label class="control-label" for="url">Your Blog's RSS Url:</label>
            <div class="controls">
                <input id="url" name="url" type="text" placeholder="RSS Url" class="input-large" required="" value="{{Input::old('url')}}">
                <p class="help-block">In order to fetch your latest posts, we need your blog, must be unique.(Eg: http://said.ozcan.co/feed)</p>
            </div>
        </div>

        <!-- Text input-->
        <div class="control-group">
            <label class="control-label" for="email">Your E-Mail:</label>
            <div class="controls">
                <input id="email" name="email" type="text" placeholder="E-Mail" class="input-xlarge" required="" value="{{Input::old('email')}}">
                <p class="help-block">You will be e-mailed when network has new post, must be unique.(Eg: foo@bar.com)</p>
            </div>
        </div>

        <!-- Button -->
        <div class="control-group">
            <label class="control-label" for="singlebutton"></label>
            <div class="controls">
                <button id="singlebutton" class="btn btn-success">Add Me</button>
            </div>
        </div>

        </fieldset>
    </form>
@stop