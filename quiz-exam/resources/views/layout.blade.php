<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="{{asset('css/layout.css')}}">
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
  
    @if (View::hasSection('styles'))
    @yield('styles')
    @endif

    <title>@yield('title')</title>
</head>
<body>
    {{-- <div class="header">
        <a href="{{route('index')}}">Home</a>
        @auth
            <a href="{{route('user.details')}}">Profile</a>
            <a href="{{ route('logout') }}">Logout</a>
        @else
            <a href="{{ route('register') }}">Register</a>
            <a href="{{ route('login') }}">Login</a>
        @endauth
    </div> --}}

    <nav class="sidebar close">
        <header>
            <div class="image-text">
                <span class="image">
                    <i class='bx bx-user icon'></i>
                </span>

                <div class="text logo-text">
                    <span class="name">Andrii Kipriianov</span>
                    <span class="email">kipriyanof64@gmail.com</span>
                </div>
            </div>

            <i class='bx bx-chevron-right toggle'></i>
        </header>

        <div class="menu-bar">
            <div class="menu">

                <li class="search-box">
                    <i class='bx bx-search icon'></i>
                    <input type="text" placeholder="Search...">
                </li>

                <ul class="menu-links">
                    <li class="nav-link">
                        <a href="#">
                            <i class='bx bx-list-ul icon' ></i>
                            <span class="text nav-text">Categories</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="#">
                            <i class='bx bx-question-mark icon' ></i>
                            <span class="text nav-text">Quizzes</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="#">
                            <i class='bx bx-bookmark icon'></i>
                            <span class="text nav-text">Favorites</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="bottom-content">
                <li class="">
                    <a href="#">
                        <i class='bx bx-log-out icon' ></i>
                        <span class="text nav-text">Logout</span>
                    </a>
                </li>       
                <li class="heart">
                    <i class='bx bx-heart icon'></i>
                </li>      
            </div>
        </div>
    </nav>

    <div class="top-bar">
        <a class="main-name text">Quizzeo</a>
        <button class="btnLogin-popup text" href="{{ route('login') }}">Login</button>
    </div>

    <div class="content">
        @yield('content')
    </div>

    <div class="footer">
        @if(Session::has('message'))
        <div>
            {{ Session::get('message') }}
        </div>
        @endif
        @if ($errors->any())
            <div>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- <span>Same footer</span> --}}
    </div>

    <script src="{{asset('js/layout.js')}}"></script>



</body>
</html>
