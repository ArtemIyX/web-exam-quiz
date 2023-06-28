@extends('layout')
@section('title', 'Quiz Creation')

@section('content')


<form id="quizForm">
    <label for="quizTitle">Quiz Title:</label>
    <input type="text" id="quizTitle" name="quizTitle">

    <label for="quizDescription">Quiz Description:</label>
    <textarea id="quizDescription" name="quizDescription"></textarea>

    <div id="questionsContainer">
        <!-- Questions will be dynamically added here -->
    </div>

    <button type="button" onclick="addQuestion()">Add Question</button>
    <button type="submit">Submit</button>
</form>

<script src="{{asset('js/quiz/createQuiz.js')}}"></script>
<script>
            document.getElementById('quizForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent form submission for this example

            // Collect all the quiz data and process it
            var formData = new FormData(this);
            var quizData = {};

            for (var pair of formData.entries()) {
                var key = pair[0];
                var value = pair[1];

                if (quizData.hasOwnProperty(key)) {
                    if (!Array.isArray(quizData[key])) {
                        quizData[key] = [quizData[key]];
                    }
                    quizData[key].push(value);
                } else {
                    quizData[key] = value;
                }
            }

            console.log(quizData);
        });
</script>

@endsection
