@extends('layout')
@section('title', 'Quiz List')


@section('content')
    <section class="home">
        <div class="hero-section">
            <h1 class="text">Check the new <i class='bx bxs-hot'></i> quiz!</h1>

        </div>
        <div id="quizContainer">
            
        </div>
    </section>

<script src="{{asset('js/quiz/loadQuizzes.js')}}"></script>
<script>
    renderQuizzes();
</script>
@endsection
