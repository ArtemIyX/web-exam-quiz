@extends('layout')
@section('title', 'Home')

@section('content')
    <h1>Welcome to Quiz-Exam</h1>
    @auth
    <!-- User is logged in -->
    <p>Welcome, {{ auth()->user()->name }}</p>
    @else
    <!-- User is not logged in -->
    <p>Please log in to access more content</p>
    @endauth
@endsection
