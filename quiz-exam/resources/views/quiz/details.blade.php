@extends('layout')
@section('title', 'Quiz Details')

@section('content')

<h1>{{ $quizDetails->title }}</h1>
<p>{{ $quizDetails->description }}</p>
<p>Author: {{ $quizDetails->author_name }}</p>
<p>Question Number: {{ $quizDetails->questions_count }}</p>
<p>Time Passed: {{ $quizDetails->times_passed }}</p>
<a href="take/{{$quizDetails->id}}">Take!</a>

@if ($errors->any())
    <div>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@endsection
