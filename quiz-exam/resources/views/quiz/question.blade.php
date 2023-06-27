
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


    async function finishClick() {
        const questionOptions = await grabAllOptionsQuestions();
        const matchesOptions = await grabAllMatchesQuestions();
        const payload = {
            quiz_id: {{$quiz_id}},
            user_id: {{$user_id}},
            options: questionOptions,
            matches: matchesOptions,
        };
        console.log(payload);
        const csrfToken = "{{ csrf_token() }}";
        const response = await fetch('/quiz/store', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify(payload),
        });
        try {
            console.log(await response.json());
        }
        catch(error) {
            console.error(error);
        }
    }
    document.addEventListener("DOMContentLoaded", function() {
        // Get a reference to the button element
        const button = document.getElementById('sendButton');

        // Bind the click event to the button and associate it with the buttonClick function
        button.addEventListener('click', finishClick);

        load();
    });

</script>
@endsection
