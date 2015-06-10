<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="siteurl" content="{{URL::to('/')}}">

        <link rel="icon" href="{{asset('favicon.ico')}}">

        <title>Backend</title>
        <link href="{{asset('/css/bootstrap.min.css')}}" rel="stylesheet">

        <link rel="stylesheet" href="{{asset('/js/colorbox/colorbox.css')}}">
        <link rel="stylesheet" href="{{asset('/css/backend/backend.css')}}">
        @yield('css')



    </head>

    <body>

        <!-- Fixed navbar -->
        <div class="navbar navbar-default navbar-fixed-top" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="{{URL::to('/')}}">GoogooFM</a>
                </div>
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li><a href="{{URL::to('/statistik')}}">Statistik</a></li>
                        <li><a href="{{URL::to('/artist')}}">Artis</a></li>
                        <li><a href="{{URL::to('/song')}}">Song</a></li>
                        <li><a href="{{URL::to('/genre')}}">Genre</a></li>
                        <li><a href="{{URL::to('/banner')}}">Banner</a></li>
                        <li><a href="{{URL::to('/program')}}">Program</a></li>
                        <li><a href="{{URL::to('/adlibs')}}">Adlibs</a></li>
                        <li><a href="{{URL::to('/audiospot')}}">Audio Spot</a></li>

                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li class=""><a href="/ruangsiar">Ruang Siar</a></li>
                        <li class=""><a href="{{ URL::to('logout') }}">Logout</a></li>
                    </ul>
                </div><!--/.nav-collapse -->
            </div>
        </div>

        <div class="container" style="min-height: 760px;">

            @yield('content')

        </div>

        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-xs-7">
                        &copy; googoofm
                    </div>

                </div>
            </div>
        </footer>

        <script src="{{asset('js/jquery.min.js')}}"></script>
        <script src="{{asset('js/bootstrap.min.js')}}"></script>
        <script src="{{asset('js/backend.js')}}"></script>

        @yield('javascripts')
    </body>
</html>
