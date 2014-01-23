@extends('layouts.master')

@section('content')

    <div class="starter-template">
        <h3>Are you a blogger in YTU?</h3>
        <p class="lead">You should join us.</p>
    </div>
    
    <form class="form-horizontal col-md-8 col-md-offset-2 well" method="post" action="/submit" id="submitForm" style="text-align:center;">
    
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
            <label class="control-label col-xs-3" for="url">Your Blog's RSS Url:</label>
            <div class="controls col-xs-9">
                <input id="url" name="url" type="text" placeholder="RSS Url" class="input-medium form-control" required="" value="{{Input::old('url')}}">
                <p class="help-block">In order to fetch your latest posts, we need your blog, must be unique.(Eg: http://said.ozcan.co/feed)</p>
            </div>
        </div>

        <div class="clearfix"></div>

        <!-- Text input-->
        <div class="control-group">
            <label class="control-label col-xs-3" for="email">Your E-Mail:</label>
            <div class="controls col-xs-9">
                <input id="email" name="email" type="text" placeholder="E-Mail" class="input-medium form-control" required="" value="{{Input::old('email')}}"/>                
                <p class="help-block">You will be e-mailed when network has new post, must be unique.(Eg: foo@bar.com)</p>
            </div>
        </div>

        <!-- Button -->
        <div class="control-group">
            <label class="control-label" for="singlebutton"></label>

            <div class="controls">
                <div class="col-xs-12">
                    <button id="singlebutton" href="#fakelink" class="btn btn-block btn-lg btn-inverse addme_button">Add me</button>
                </div>                
            </div>
        </div>

        </fieldset>
    </form>
@stop