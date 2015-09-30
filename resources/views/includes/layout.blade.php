<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@section('title') @if(isset($title)) {{ $title }} @else Target Ink @endif @show</title>
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300|Montserrat" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ elixir('css/all.css') }}">

        <link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/>

        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <!--JQUERY INCLUDES-->
        <style type="text/css">
        i.icon-move{
            cursor: move;
        }

        body.dragging, body.dragging * {
          cursor: move !important;
        }

        .dragged {
          position: absolute;
          opacity: 0.5;
          z-index: 2000;
        }

        ol.example li.placeholder {
          position: relative;
          /** More li styles **/
        }
        ol.example li.placeholder:before {
          position: absolute;
          /** Define arrowhead **/
        }

        .sorted_table tr.placeholder {
            display: block;
            background: red;
            position: relative;
            margin: 0;
            padding: 0;
            border: none;
        }

        .sorted_table tr.placeholder:before {
            content: "";
            position: absolute;
            width: 0;
            height: 0;
            border: 5px solid transparent;
            border-left-color: red;
            margin-top: -5px;
            left: -5px;
            border-right: none;
        }
</style>

        
    </head>
    <body>
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

        <script src="{{ asset('js/jquery-1.11.3.min.js') }}"></script>
        <script src="{{ elixir('js/all.js') }}"></script>

        <script src="/js/jquery.maskedinput.min.js" type="text/javascript"></script>

        <link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/jqueryui-editable/css/jqueryui-editable.css" rel="stylesheet"/>
        <script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/jqueryui-editable/js/jqueryui-editable.min.js"></script>
        
        @yield('scripts')
    </body>
</html>