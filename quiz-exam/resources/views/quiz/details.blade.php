@extends('layout')
@section('title', 'Quiz Details')

@section('styles')

<link rel="stylesheet" href="{{asset('css/welcomeQuiz.css')}}">
@endsection

@section('content')

<div class="welcome-screen">
    <h1>{{ $quizDetails->title }}</h1>
    <div class="information">
        <p class="description">Description: {{ $quizDetails->description }}</p>
        <p class="author">Author: {{ $quizDetails->author_name }}</p>
        <p class="question-num">Question Number: {{ $quizDetails->questions_count }}</p>
        <p class ="time-passed">Time Passed: {{ $quizDetails->times_passed }}</p>
    </div>
    <div>
        @auth
        <div class="btnTake">
            <p>Take!</a>
        </div>
        @else
            <p class="unauth">Login to take quiz</p>
        @endauth
    </div>
</div>

@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const btnTake = document.querySelector('.btnTake');
        btnTake.addEventListener("click" , () => {
            window.location.href = `/quiz/take/{{ $quizDetails->id }}`;
        });
    });
</script>
@endsection
