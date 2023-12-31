@extends('layout')
@section('title', 'Quiz Result')

@section('styles')
<link rel="stylesheet" href="{{asset('css/results.css')}}">
@endsection

@section('content')
<div id="loadingDiv">
<p>
    Loading results...
</p>
</div>
<div id="loadedDiv" style="display:none;">
    <div class="result-container">
        <h1>Quiz Result</h1>
        <div class="submitter-information">
            <h2>User Details</h2>
            <p>
                Submitter: <span id="user_name"></span>
            </p>
        </div>
        <div class="quiz-information">
            <h3 id="quiz_title"></h3>
            <p>
                Description: <span id="quiz_desc"></span>
            </p>
            <p>
                Questions: <span id="quiz_question_number"></span>
            </p>
            <p>
                Times Passed: <span id="quiz_times_passes"></span>
            </p>
        </div>

        <div>
            <h2>Results</h2>
            <p>
                Mark: <span id="mark"></span>/<span id="max_mark"></span>
            </p>
        </div>

    <div id="questions-container">

    </div>
</div>

</div>
@endsection

@section('scripts')
<script src="{{ asset('js/quiz/question.js') }}"></script>
<script src="{{ asset('js/quiz/results.js') }}"></script>
<script src="{{ asset('js/loading.js') }}"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        async function load() {
            const results = await loadResults({{$sub_id}});
            applyUserDetails(results.submitter);
            applyQuizDetails(results.submission.quiz);
            applyTotal(results.total);
            await renderQuestions(results.submission.quiz.questions);
            await applyOptions(results.total.correct_options);
            await applyMatches(results.total.correct_matches);
        }
        load().then(function() {
            finishdLoading();    
        });
    });



</script>
@endsection
