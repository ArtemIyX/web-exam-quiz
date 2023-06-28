@extends('layout')
@section('title', 'Quiz Creation')

@section('content')
<h1>Quiz Creator</h1>

  <div id="quizContainer">
    <button onclick="addQuestion()">Add Question</button>
  </div>

<script src="{{asset('js/quiz/createQuiz.js')}}"></script>
<script>

</script>

@endsection
