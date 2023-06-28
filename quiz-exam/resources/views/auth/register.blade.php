@extends('layout')
@section('title', 'Sign up')

@section('styles')
<link rel="stylesheet" href="{{asset('css/register.css')}}">
<link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
@endsection

@section('content')
    <div class="wrapper">
        <div class="form-box register">
            <h2>Registration</h2>
            <form method="POST" action="{{ route('register') }}" accept-charset="UTF-8">                @csrf
                <div class = "input_box">
                    <i class='bx bx-user icon'></i>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required autofocus>
                    <label for="name">Name</label>
                </div>
                <div class = "input_box">
                    <i class='bx bx-envelope icon'></i>
                    <input type="text" name="email" id="email" value="{{ old('email') }}" required>
                    <label for="text">Email</label>
                </div>
                <div class = "input_box">
                    <i class='bx bx-lock-alt icon' ></i>
                    <input type="password" name="password" id="password" required>
                    <label for="password">Password</label>
                </div>
                <div class="input_box">
                    <input type="password" name="password_confirmation" id="password_confirmation" required>
                    <label for="password_confirmation">Confirm Password</label>
                </div>
                <button type="submit" class="btn">Register</button>
                <div class="login-register">
                    <p>Already have an account? <a href="{{ route('login')}}" class="login-link">Login</a></p>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')

@endsection
