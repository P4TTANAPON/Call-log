<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SAMART/CALLLOG</title>

    <!-- Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>

    <!-- Styles -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}
	<!---->
	<link href="{{ url('vendor/selectize/css/selectize.bootstrap3.css') }}" rel="stylesheet">
	<link href="{{ url('/js/jquery/ui/1.11.4/themes/smoothness/jquery-ui.css') }}" rel="stylesheet">

	<!-- JavaScripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
	<!---->
	<script src='{{ url("vendor/selectize/js/standalone/selectize.min.js") }}' type="text/javascript"></script>
	<script src="{{ url('js/jquery/ui/1.11.4/jquery-ui.js') }}" type="text/javascript"></script>
	
	{{-- <link rel="manifest" href="manifest.json"> --}}
	{{-- <script src="{{ url('/js/main.js') }}"></script> --}}
	
    <style>
        body {
            font-family: 'Lato';
            background-color: #e9ebee;
        }

        .fa-btn {
            margin-right: 6px;
        }

        /*.table-hover tbody tr:hover td, .table-hover tbody tr:hover th {*/
            /*background-color: #fcf8e3;*/
        /*}*/

        .table-custom-pad thead tr th, .table-custom-pad tbody tr td, .table-custom-pad tfoot tr td {
            padding: 2px 5px;
        }

        .star {
            color: orange;
        }
        
        /*@media screen and (min-width: 870px) {*/
            #black_ribbon_badge {
                position: fixed;
                bottom: 10px;
                left: 10px;
                background-position: 0px 0px;
                background-repeat: no-repeat;
                z-index: 2000000005;
                width: 61px;
                height: 61px;
                border: 0px none !important;
                background-image: url('/images/black_ribbon.png');
            }
        /*}*/

        /*warning background color #fcf8e3*/
    </style>

    <script>
        function h(e) {
          $(e).css({'height':'auto','overflow-y':'hidden'}).height(e.scrollHeight);
        }

        $(function() {
            $('textarea').each(function () {
              h(this);
            }).on('input', function () {
              h(this);
            });
        });
    </script>
</head>
<body id="app-layout">
    <nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
				
                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    SAMART/CALLLOG
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
					<li class="@yield('job_active')"><a href="{{ url('/job') }}">JOB</a></li>
                    @if(Request::user())
                        @if(Request::user()->team == 'CC' || Request::user()->team == 'SP')
                            <li class="@yield('hw_active')"><a href="{{ url('/hw') }}">HARDWARE</a></li>
                        @endif
                        @if(Request::user()->team == 'OBS')
                            <li class="@yield('hw_active')"><a href="{{ url('/hw') }}">HARDWARE</a></li>
                            <li class="@yield('dashboard_active')"><a href="{{ url('/dashboard') }}">DASHBOARD</a></li>
                            <li class="@yield('dashboard_sla_active')"><a href="{{ url('/dashboard_sla') }}">DASHBOARD_SLA</a></li>
                            <li class="@yield('member_active')"><a href="{{ url('/member') }}">DASHBOARD_SLA</a></li>
                        @endif
                    @endif
                    
                    <!-- <li class="@yield('survey_active')"><a href="{{ url('/sat-survey') }}">SURVEY</a></li> -->
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">Login</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')
	
	<!-- <div class="container">
		<div class="row">
			<div class="col-md-12">
				<footer>
				
<?php
	echo sys_get_temp_dir();
?>

					<p class="text-center">{{ isset($tags[0]) ? 'Version '.$tags[0] : '' }}</p>
				</footer>
			</div>
		</div>
	</div> -->
</body>
</html>
