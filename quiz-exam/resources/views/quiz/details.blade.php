@extends('layout')
@section('title', 'Quiz Details')

@section('content')

<div>
    <h1>{{ $quizDetails->title }}</h1>
    <p>{{ $quizDetails->description }}</p>
    <p>Author: {{ $quizDetails->author_name }}</p>
    <p>Question Number: {{ $quizDetails->questions_count }}</p>
    <p>Time Passed: {{ $quizDetails->times_passed }}</p>
    <hr>
    <div>
        @auth
            <a href="take/{{$quizDetails->id}}">Take!</a>
        @else
            <p>Login to take quiz</p>
        @endauth
    </div>
</div>
@endsection
