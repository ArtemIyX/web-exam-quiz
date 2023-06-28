@extends('layout')
@section('title', 'Quiz Result')

@section('content')
<h1>Quiz Result</h1>
<div id="loadingDiv">
<p>
    Loading results...
</p>
</div>
<div id="loadedDiv" style="display:none;">
    <h2>User Details</h2>
    <p>
        Submitter: <span id="user_name"></span>
    </p>
    <h2>Quiz Details</h2>
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
    <h2>Results</h2>
    <p>
        Mark: <span id="mark"></span>/<span id="max_mark"></span>
    </p>
</div>



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
        }
        load().then(function() {
            finishdLoading();
        });
    });

</script>
@endsection
