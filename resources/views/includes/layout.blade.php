<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <title>@yield('sectionTitle') | Target Ink</title>
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300|Montserrat" rel="stylesheet" type="text/css">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="{{ elixir('build/css/app.css') }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        @yield('styles')
    </head>

    @if(auth()->check() && auth()->user()->admin)
    <body class="admin">
    @else
    <body class="user">
    @endif
        <div class="nav-container">
            <div class="container">
                @if(auth()->check() && auth()->user()->admin)
                <div class="btn-group-justified main-nav" role="group">
                    <a href="{{ url('/') }}" class="btn btn-default btn-menu">Maintenance Accounts</a>
                    <a href="{{ request()->url() }}" class="btn btn-default btn-menu active">@yield('sectionTitle')</a>
                    <a href="{{ url('auth/logout') }}" class="btn btn-default btn-menu btn-logout">Logout</a>
                </div>
                @elseif(auth()->check())
                <div class="btn-group-justified main-nav" role="group">
                    <a href="{{ url('/') }}" class="btn btn-default btn-menu">Maintenance Accounts</a>
                    <a href="{{ request()->url() }}" class="btn btn-default btn-menu active">@yield('sectionTitle')</a>
                    <a href="{{ url('auth/logout') }}" class="btn btn-default btn-menu btn-logout">Logout</a>
                </div>
                @endif
            </div>
        </div>
        <div class="container">
            @yield('content')
        </div>
        <script src="{{ elixir('build/js/app.js') }}"></script>
        @if(auth()->check())
            <script src="/js/validation.js?{{ config('app.hash') }}"></script>
            @yield('scripts')
        @endif

        <script src="https://cdnjs.cloudflare.com/ajax/libs/airbrake-js/0.5.8/client.min.js" type="text/javascript"></script>
        <script type="text/javascript">
        var airbrake = new airbrakeJs.Client({projectId: '6e24fe7e9906ef1d07138da38487bc64', projectKey: '6e24fe7e9906ef1d07138da38487bc64'});
        airbrake.setHost("https://helio-errbit.herokuapp.com/");
        </script>
    </body>
</html>
