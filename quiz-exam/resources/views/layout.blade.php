<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
</head>
<body>
    <div class="header">
        @auth
            <a href="{{ route('logout') }}">Logout</a>
        @else
            <a href="{{ route('register') }}">Register</a>
            <a href="{{ route('login') }}">Login</a>
        @endauth
    </div>

    <div class="content">
        @yield('content')
    </div>

    <div class="footer">
        <span>Same footer</span>
    </div>
</body>
</html>
