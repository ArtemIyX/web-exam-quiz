@extends('layout')
@section('title', 'Quiz Creation')

@section('content')
<h2>Quiz Creator</h2>
<button onclick="addQuestion()">Add Question</button>
<div id="questions"></div>
<script src="{{asset('js/quiz/createQuiz.js')}}"></script>
<script>

</script>

@endsection
