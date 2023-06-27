@extends('layout')
@section('title', 'Home')

@section('content')
    <h1>Welcome to Quiz-Exam</h1>
    <p>Success value: {{ session('success') }}</p>
@endsection
