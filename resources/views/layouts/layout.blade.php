<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>CvSU-Naic ISPS-SDS Portal</title>

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/all.css') }}">
        <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

        <!-- Scripts -->
        <script src="{{ asset('js/jquery-3.4.1.js') }}"></script>
        <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    </head>

    <body class="bg-secondary">
        @yield('verify-email')
        <nav class="navbar navbar-expand-sm navbar-dark bg-success border-top border-bottom fixed-top d-flex py-0 m-2">
            <a class="navbar-brand" href="/">
                <img src="{{ asset('img/logo.png') }}" alt="Logo" id="logo">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        
            <div class="collapse navbar-collapse d-sm-flex justify-content-sm-between @auth justify-content-lg-end @endauth" id="navbarToggler">
                <ul class="navbar-nav nav-fill">
                    <li class="nav-item">
                        <a href="{{ route('home') }}" class="nav-link px-2  @if(Route::currentRouteName()== 'home') active @endif "> Home </a>
                    </li>
                    <li class="nav-item px-2">
                        <a class="nav-link" href="#">Menu</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle " data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Menu</a>
                        <div class="dropdown-menu bg-success">
                            <a class="dropdown-item-custom text-center " href="#">Menu</a>
                            <a class="dropdown-item-custom text-center" href="#"><span class="fa fa-lock"></span> Menu</a>
                        </div>
                    </li>
                </ul>   
                <ul class="navbar-nav nav-fill text-nowrap @auth d-lg-none @endauth">
                    @auth    
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">{{ auth()->user()->name }}</a>
                        <div class="dropdown-menu bg-success">
                            <a class="dropdown-item-custom text-center " href="#">Menu</a>
                            <a class="dropdown-item-custom text-center " href="#">Menu</a>
                            <a class="dropdown-item-custom text-center " href="#">Menu</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <form action="{{ route('auth.signout') }}" method="post">
                            @csrf
                            <button type="submit" class="nav-link px-2 bg-transparent border-0 mx-auto"> Sign out</button>
                        </form>
                    </li>                        
                    @endauth


                    @guest
                    <li class="nav-item">
                        <a class="nav-link px-2 @if(Route::currentRouteName() == 'auth.signup') active @endif" href="{{ route('auth.signup') }}">Sign up</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-2 @if(Route::currentRouteName() == 'auth.signin') active @endif" href="{{ route('auth.signin') }}">Sign in</a>
                    </li>
                    @endguest                                              
                </ul>
            </div>
        </nav> 
        <div class="d-flex bg-warning min-vh-100">
            @auth
            <div class="col-3 d-none d-lg-flex flex-lg-column bg-danger">
                dd
            </div>    
            @endauth
            
            <div class="d-flex flex-column justify-content-start align-items-center mx-2 bg-primary vw-100">
                <div class="mb-5 pb-5" id="logo">
                    &nbsp;
                </div>
                
                @yield('content')            
            </div>
        </div>
    </body>
</html>
