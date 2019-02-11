<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Cofee') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <!--<link href="{{ asset('css/app.css') }}" rel="stylesheet">-->

    
    <!-- Icons -->
    <link type="text/css" rel="stylesheet" href="/css/bootstrap.min.css" media="all">

</head>
<body>

    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Branding Image -->
                    <!-- <a class="navbar-brand" href="{{ url('/home') }}"> -->
                        <a class="navbar-brand text" style="position: absolute; width: 100%; left: 0; text-align: center; margin:0 auto;">
                            {{ config('app.name', 'Cofee') }}
                        </a>
                        
                        <!-- logotipo -->
                        <a class="navbar-brand" rel="home" title="Papel Plus Papelaria">
                            <img style="position: absolute; max-width:100px; max-height:40px; margin-top: -7px;"
                            src="/logo_plus.jpg">
                        </a>

                        <!-- Collapsed Hamburger -->
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                            <span class="sr-only">Toggle Navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>

                    <div class="collapse navbar-collapse" id="app-navbar-collapse">
                        <!-- Left Side Of Navbar -->
                        <ul class="nav navbar-nav">
                            &nbsp;
                        </ul>

                        <!-- Right Side Of Navbar -->
                        <ul class="nav navbar-nav navbar-right">
                            <!-- Authentication Links -->
                            @if (Auth::guest())
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <!-- <li><a href="{{ route('register') }}">Register</a></li> -->
                            @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="glyphicon glyphicon-user"></span>
                                 {{ Auth::user()->name }} <span class="caret"></span>
                             </a>

                             <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a align="center" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                    <span class="glyphicon glyphicon-off"></span> Sair
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')
</div>

<!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
<!--     <script src="//code.jquery.com/jquery-3.2.1.js"></script> -->
<!--     <script src="{{ asset('/js/jquery-3.2.1.min.js') }}"></script> -->
<!--     <script type="text/javascript" src="/js/jquery-3.2.1.min.js"></script> -->
<!--         <script type="text/javascript" src="/js/jquery-ui.min.js"></script>
     -->
     <!--link para maskMoney-->
    <script type="text/javascript" src="/js/jquery.maskMoney.js" ></script>
    <!--mascara para moeda-->
    <script type="text/javascript">
        $(document).ready(function(){
              $("input.dinheiro").maskMoney({showSymbol:false, decimal:",", thousands:"."});           
        });
    </script>
    
    <script type="text/javascript">
        var url = "http://localhost:8000/";
    </script>

@yield('script')
</body>
</html>
