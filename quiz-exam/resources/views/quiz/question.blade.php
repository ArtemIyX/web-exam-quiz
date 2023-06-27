
@extends('layout')
@section('title', 'Quiz')

@section('content')
<div id="questions-container"></div>
<button id="sendButton">Finish</button>
<script src="{{ asset('js/quiz/question.js') }}"></script>
<script>
    async function load() {
        let res = await loadQuestions({{$quiz_id}});
        renderQuestions(res);
    }
    load();

    async function finishClick() {
        const questionOptions = await grabAllOptionsQuestions();
        const matchesOptions = await grabAllMatchesQuestions();
        console.log(questionOptions);
        console.log(matchesOptions);
    }

    // Get a reference to the button element
    const button = document.getElementById('sendButton');

    // Bind the click event to the button and associate it with the buttonClick function
    button.addEventListener('click', finishClick);
</script>
@endsection
