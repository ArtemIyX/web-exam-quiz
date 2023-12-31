@extends('layout')
@section('title', 'Quiz Creation')

@section('styles')
<link rel="stylesheet" href="{{asset('css/create.css')}}">
@endsection

@section('content')
<div class="create-container">
    <h1>Create Quiz</h1>
    <div class="header">
        <label for="quiz-name">Quiz Name:</label>
        <input type="text" id="quiz-name" placeholder="Quiz Name"><br>    
        <label for="quiz-description">Quiz Description:</label>
        <input type="text" id="quiz-description" placeholder="Quiz Description"><br>
    </div>

    <div class="quiz-buttons">
        <button onclick="addQuestion('radio')">Add Radio Type Question</button>
        <button onclick="addQuestion('dropdown')">Add Dropdown Type Question</button>
    </div>

    <div id="quiz-container"></div>
    <button class="submitQuiz" onclick="submitQuiz()">Submit Quiz</button>
</div>

@endsection

@section('scripts')
<script src="{{asset('js/quiz/createQuiz.js')}}"></script>
<script>
    async function submitQuiz() {
        try {
            const payload = getQuiz();
            console.log(payload);
            const csrfToken = "{{ csrf_token() }}";

            const response = await fetch('/api/quiz/create', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify(payload),
            });

            const data = await response.json();
            if(data.retCode == 200) {
                console.log(data.result.id);
                window.location.href = `/quiz/${data.result.id}`;
            }
            else {
                console.error("Sumbit errror: " + data.retMsg);
            }
        }
        catch(error) {
            error.than(() => {
                console.log(error);
            });
        }

    }
</script>
@endsection
