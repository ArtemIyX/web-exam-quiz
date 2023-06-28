@extends('layout')
@section('title', 'Quiz List')


@section('content')
<section class="home">
    <h1>Quiz List</h1>
    <div id="quizContainer"></div>
</section>
@endsection

@section('scripts')
<script src="{{asset('js/quiz/loadQuizzes.js')}}"></script>
<script>
    renderQuizzes();
</script>
@endsection
