<!doctype html>
<html lang="en">
    <head>
        <title>YTU-CE Blogger Network</title>
        <meta name="description" content="Yildiz Teknik Üniversitesi Blog Platformu">
        <meta name="keywords" content="YTU Blogger Network, Yıldız Teknik Üniversitesi Blogger Ağı, Yıldız, Teknik, Üniversites, Blogging, Blog">
        <meta name="author" content="Said Özcan">
        <meta charset="UTF-8">
        <link rel="stylesheet" href="{{ URL::asset('assets/css/bootstrap.css') }}">        
        <link rel="stylesheet" href="{{ URL::asset('assets/css/app.css') }}">
        <link rel="stylesheet" href="{{ URL::asset('assets/css/font-awesome.min.css') }}">        
        <link rel="stylesheet" href="{{ URL::asset('assets/css/starter-template.css') }}">
        <link rel="stylesheet" href="{{ URL::asset('assets/css/flat-ui.css') }}">
        <link rel="shortcut icon" href="{{URL::asset('assets/img/favicon.png')}}"  />
        <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
        <!--[if lt IE 9]>
            <script src="{{ URL::asset('assets/js/html5shiv.js') }}"</script>            
        <![endif]-->

        <script>
          (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
          (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
          m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
          })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

          ga('create', 'UA-47467204-1', 'ytubloggers.com');
          ga('send', 'pageview');

        </script>
        
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
                    <a class="navbar-brand" href="/">YTU Bloggers</a>

                    
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

                        @if(Request::path() === 'submit' || Request::path() === 'community')
                            <li class="dropdown active">
                        @else
                            <li class="dropdown">
                        @endif
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Register <b class="caret"></b></a>
                            <span class="dropdown-arrow"></span>
                            <ul class="dropdown-menu">
                                <li><a href="/submit">Submit Blog</a></li>
                                <li><a href="/community">Community</a></li>                                
                            </ul>
                        </li>
                        
                        @if(Request::path() === 'api' || Request::path() === 'doc')
                            <li class="dropdown active">
                        @else
                            <li class="dropdown">
                        @endif
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Developer <b class="caret"></b></a>
                            <span class="dropdown-arrow"></span>
                            <ul class="dropdown-menu">
                                <li><a href="/api">Api</a></li>
                                <li><a href="/doc">Api Doc</a></li>                                
                            </ul>
                        </li>
                        <li><a href="/rss" target="_blank">Rss</a></li>
                    </ul>
                </div><!--/.nav-collapse -->
            </div>
        </div>

        <div class="container">

            @yield('content')

        </div><!-- /.container -->
        
        <div class="mtl pbl" style="padding-bottom:0px !important;margin-top:10%;">
            <div class="bottom-menu bottom-menu-inverse">
                <div class="container">
                    <div class="row">
                        <form method="post" action="/newsletter" id="newsletterForm">
                            <h4 class="col-md-6 col-md-push-4 bottom-mail-heading">Signup to the our Newsletter</h4>
                            <div class="clearfix"></div>
                            <div class=" col-md-6">
                                <input name="email" type="text" class="col-xs-6 col-md-push-4 form-control bottom-mail" placeholder="Signup to the Newsletter" value="">
                            </div>

                            <div class=" col-md-6">
                                <div class="controls">
                                    <div class="col-xs-9 col-md-push-4">
                                        <button id="singlebutton" href="#fakelink" class="btn btn-primary btn-lg ">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="row">                       

                        <div class="col-md-6 col-md-push-3" style="margin-top:50px;">
                            <ul class="bottom-links bottom-menu">
                                <li><a href="/about">About</a></li>
                                <li><a href="/submit">Submit Blog</a></li>
                                <li><a href="/community">Community</a></li>
                                <li><a href="/api">Api</a></li>
                                <li><a href="/doc">Api Documentation</a></li>
                                <li><a href="/rss">Rss</a></li>
                            </ul>
                        </div>
                        
                    </div>
                </div>
            </div>
            </div> <!-- /bottom-menu-inverse -->
        </div>
    </body>
    {{-- Scripts goes here, to load page faster --}}    
    <script src="{{ URL::asset('assets/js/jquery-1.10.2.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/jquery-ui-1.10.3.custom.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/jquery.ui.touch-punch.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/bootstrap.min.js') }}"></script>    
    <script src="{{ URL::asset('assets/js/jquery.validate.min.js') }}"></script>        
    <script src="{{ URL::asset('assets/js/app.js') }}"></script>
    <script src="{{ URL::asset('assets/js/bootstrap-select.js') }}"></script>
    <script src="{{ URL::asset('assets/js/bootstrap-switch.js') }}"></script>
    <script src="{{ URL::asset('assets/js/flatui-checkbox.js') }}"></script>
    <script src="{{ URL::asset('assets/js/flatui-radio.js') }}"></script>
    <script src="{{ URL::asset('assets/js/jquery.tagsinput.js') }}"></script>
    <script src="{{ URL::asset('assets/js/jquery.placeholder.js') }}"></script>
    <script src="{{ URL::asset('assets/js/jquery.stacktable.js') }}"></script>
    <script src="http://vjs.zencdn.net/4.3/video.js"></script>
    <script src="{{ URL::asset('assets/js/application.js') }}"></script>
</html>