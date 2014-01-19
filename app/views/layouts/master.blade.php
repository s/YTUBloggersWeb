<!doctype html>
<html lang="en" ng-app="SearchHub">
    <head>
        <title>YTU-CE Blogger Network</title>

        <link rel="stylesheet" href="{{ URL::asset('assets/css/bootstrap.css') }}">
        <link rel="stylesheet" href="{{ URL::asset('assets/css/app.css') }}">
        <link rel="stylesheet" href="{{ URL::asset('assets/css/font-awesome.min.css') }}">        
        <link rel="stylesheet" href="{{ URL::asset('assets/css/starter-template.css') }}">        
        <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
        <!--[if lt IE 9]>
            <script src="{{ URL::asset('assets/js/html5shiv.js') }}"</script>            
        <![endif]-->
        
    </head>
    <body>

        <div class="navbar navbar-inverse navbar-fixed-top bs-docs-nav" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="/">Blogger</a>
                </div>                                
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        @if(Request::path() === '/')
                            <li class="active">
                        @else
                            <li>
                        @endif
                        <a href="/">Home</a>
                        </li>
                        @if(Request::path() === 'submit')
                            <li class="active">                            
                        @else
                            <li>
                        @endif
                        <a href="/submit">Submit Blog</a>
                        </li>
                        @if(Request::path() === 'community')
                            <li class="active">
                        @else
                            <li>
                        @endif
                        <a href="/community">Community</a>
                    </ul>
                </div><!--/.nav-collapse -->
            </div>
        </div>

        <div class="container">            

            @yield('content')

        </div><!-- /.container -->
        

    </body>
    {{-- Scripts goes here, to load page faster --}}    
    <script src="{{ URL::asset('assets/js/jquery-1.10.2.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/bootstrap.min.js') }}"></script>    
    <script src="{{ URL::asset('assets/js/jquery.validate.min.js') }}"></script>        
    <script src="{{ URL::asset('assets/js/app.js') }}"></script>
</html>