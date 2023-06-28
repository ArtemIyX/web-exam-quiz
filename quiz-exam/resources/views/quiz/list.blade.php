@extends('layout')
@section('title', 'Quiz List')

@section('styles')

<link rel="stylesheet" href="{{asset('css/quizPage.css')}}">
@endsection

@section('content')
<section class="home">
    <div class="hero-section">
        <div class="total text"><i class='bx bxs-hot'></i>Total quizzes: 
            <span class="number">20</span>
        </div>
    </div>

    <div id="quizContainer">
        <div class="quiz-grid">
            
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script src="{{asset('js/quiz/loadQuizzes.js')}}"></script>
<script>
    renderQuizzes();
</script>
@endsection
