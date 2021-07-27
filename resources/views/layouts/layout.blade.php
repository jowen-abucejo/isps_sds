<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name') }}</title>

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/all.css') }}">
        <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

        <!-- Scripts -->
        <script src="{{ asset('js/jquery-3.4.1.js') }}"></script>
        <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    </head>

    <body class="bg-warning">
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
                        <a href="{{ route('home') }}" class="nav-link px-2  @if(Route::currentRouteName() == 'home') active @endif "> Home </a>
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
                    @if (auth()->user()->hasVerifiedEmail())   
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">{{ (auth()->user()->student)? auth()->user()->student->first_name : auth()->user()->name}}</a>
                        
                        <div class="dropdown-menu bg-success">
                            <a class="dropdown-item-custom text-center " href="#">Menu</a>
                            <a class="dropdown-item-custom text-center " href="#">Menu</a>
                            <a class="dropdown-item-custom text-center " href="#">Menu</a>
                        </div>
                    </li>
                    @endif
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

        @auth 
        <div class="fixed-top col-lg-3 d-none d-lg-flex flex-lg-column col-xl-2 p-2 vh-100">
            <div class="mb-5 pb-4">
            </div>   
            @if (auth()->user()->isAdmin())
            <p class="text-center bg-dark text-light m-0 pt-5"><span class="fas fa-user-tie fa-5x"></span></p>
            <p class="text-center bg-dark text-light m-0 ">{{ auth()->user()->name }}</p>
            <p class="text-center bg-dark text-light m-0 pb-5"><small>Admin</small></p>
            @else
            <p class="text-center bg-dark text-light m-0 pt-5"><span class="fas fa-user-graduate fa-5x"></span></p>
            @if (auth()->user()->student)
            <p class="text-center bg-dark text-light m-0">{{ auth()->user()->student->first_name }}</p>
            <p class="text-center bg-dark text-light m-0 pb-5"><small>{{ auth()->user()->student->course->course_desc }}</small></small>
            @else 
            <p class="text-center bg-dark text-light m-0 pb-5">{{ auth()->user()->name }}</p>
            @endif  
            @endif

            <nav class="navbar navbar-expand-sm navbar-dark bg-secondary border-bottom d-lg-flex justify-content-center h-100 overflow-auto">
                <ul class="navbar-nav nav-fill flex-lg-column align-self-start" id="side_menus">
                    @if (auth()->user()->hasVerifiedEmail())
                    @if (auth()->user()->isAdmin())
                    @php
                        $to_manage = auth()->user()->to_manage;
                    @endphp    
                    <li class="nav-item">
                        <a href="{{ route('su.dashboard') }}" class="nav-link px-2  @if(Route::currentRouteName() == 'su.dashboard') active @endif ">HOME</a>
                    </li>
                    @for ($i = 0; $i<$to_manage->count() && $i<5; $i++)
                    <li class="nav-item">
                        <a href="{{ route('su.manage',['scholarship_code' => Str::lower(Str::replace(' ', '_', $to_manage->get($i)->scholarship_code)) ]) }}" class="nav-link px-2  @if(Route::currentRouteName() == 'su.manage' && $to_manage->get($i)->scholarship_code === str_replace('_', ' ', $scholarship_code) ) active @endif ">{{ $to_manage->get($i)->description }}</a>
                    </li>
                    @endfor
                    @if ($to_manage->count()>5)
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">MANAGE OTHERS</a>
                        
                        <div class="dropdown-menu bg-secondary shadow mw-100 text-wrap text-center">
                            @for ($i = 4; $i<$to_manage->count(); $i++)
                            <a href="{{ route('su.manage',['scholarship_code' => Str::lower(Str::replace(' ', '_', $to_manage->get($i)->scholarship_code))]) }}" class="dropdown-item-custom text-wrap small @if(Route::currentRouteName() == 'su.manage') active @endif ">{{ $to_manage->get($i)->description }}</a>
                            @endfor
                        </div>
                    </li>
                    @endif
                    <li class="nav-item">
                        <a href="{{ route('su.courses') }}" class="nav-link px-2  @if(Route::currentRouteName() == 'su.courses') active @endif ">CVSU-NAIC PROGRAM REGISTRY</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">SETTINGS</a>
                        
                        <div class="dropdown-menu bg-secondary shadow mw-100 text-wrap text-center">
                            <a href="{{ route('su.scholarships') }}" class="dropdown-item-custom text-wrap small  @if(Route::currentRouteName() == 'su.scholarships') active @endif ">NEW SCHOLARSHIPS</a>
                            <a href="{{ route('su.requirements') }}" class="dropdown-item-custom text-wrap small  @if(Route::currentRouteName() == 'su.requirements') active @endif ">ADD REQUIREMENTS</a>
                            <a href="{{ route('su.downloadables') }}" class="dropdown-item-custom text-wrap small  @if(Route::currentRouteName() == 'su.downloadables') active @endif ">ADD DOWNLOADABLES</a>
                        </div>
                    </li>
                    @else
                    <li class="nav-item">
                        <a href="{{ route('student.dashboard') }}" class="nav-link px-2  @if(Route::currentRouteName() == 'student.dashboard') active @endif ">DASHBOARD</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('student.profile') }}" class="nav-link px-2  @if(Route::currentRouteName() == 'student.profile') active @endif ">PROFILE</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('student.scholarships') }}" class="nav-link px-2  @if(Route::currentRouteName() == 'student.scholarships') active @endif ">MY SCHOLARSHIPS </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('student.downloadables') }}" class="nav-link px-2  @if(Route::currentRouteName() == 'student.downloadables') active @endif ">DOWNLOADABLES</a>
                    </li>
                    @endif
                    <li class="nav-item">
                        <a href="{{ route('pass.change') }}" class="nav-link px-2 @if(Route::currentRouteName() == 'pass.change') active @endif">CHANGE PASSWORD</a>
                    </li> 
                    @endif
                    <li class="nav-item">
                        <form action="{{ route('auth.signout') }}" method="post">
                            @csrf
                            <button type="submit" class="nav-link px-2 bg-transparent border-0 mx-auto"> SIGNOUT</button>
                        </form>
                    </li> 
                </ul>   
            </nav>    
        </div>
        @endauth

        <div class="d-flex min-vh-100">
            @auth
            <div class="col-lg-3 col-xl-2 d-none d-lg-flex flex-lg-column">
            </div>    
            @endauth
            
            <div class="d-flex flex-column justify-content-start align-items-center mx-2 vw-100">
                <div class="mb-5 pb-5" id="logo">
                    &nbsp;
                </div>                
                @yield('content')            
            </div>
        </div>
        @yield('js_area')
    </body>
</html>
