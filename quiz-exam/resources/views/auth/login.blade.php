@extends('layout')
@section('title', 'Sign in')

@section('styles')
<link rel="stylesheet" href="{{asset('css/login.css')}}">
<link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
@endsection

@section('content')
    <div class="wrapper">
        <div class="form-box login">
            <h2>Login</h2>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class = "input_box">
                    <i class='bx bx-envelope icon'></i>
                    <input type="text" name="email" id="email" value="{{ old('email') }}" required autofocus>
                    <label for="email">Email</label>
                </div>
                <div class = "input_box">
                    <i class='bx bx-lock-alt icon' ></i>
                    <input type="password" name="password" id="password" required>
                    <label for="password">Password</label>
                </div>
                <div class="remember-me">
                    <label for="remember"><input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    Remember Me</label>
                </div>
                <button type="submit" class="btn">Login</button>
                <div class="login-register">
                    <p>Don't have an account? <a href="{{ route('register')}}" class="register-link">Register</a></p>
                </div>
            </form>
        </div>
    <div>
@endsection

@section('scripts')

@endsection
