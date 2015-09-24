<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@section('title') @if(isset($title)) {{ $title }} @else Target Ink @endif @show</title>
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300|Montserrat" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/all.css') }}">
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <div class="nav-container">
            <div class="container">
                <div class="btn-group-justified main-nav" role="group">
                    <a href="#" class="btn btn-default btn-menu active">Maintenance Accounts</a>
                    <a href="#" class="btn btn-default btn-menu">Admin Services</a>
                    <a href="{{ url('auth/logout') }}" class="btn btn-default btn-menu btn-logout">Logout</a>
                </div>
            </div>
        </div>
        <div class="container">
            @yield('content')
        </div>
        <script src="{{ asset('js/jquery-1.11.3.min.js') }}"></script>
        <script src="{{ asset('js/all.js') }}"></script>
    </body>
</html>