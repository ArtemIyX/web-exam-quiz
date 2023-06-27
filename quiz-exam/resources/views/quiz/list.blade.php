@extends('layout')
@section('title', 'Quiz List')

@section('content')
<h1>Quiz List</h1>
<div id="quizContainer"></div>

<script src="{{asset('js/quiz/loadQuizzes.js')}}"></script>
@endsection
