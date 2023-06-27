
@extends('layout')
@section('title', 'Quiz')

@section('content')
<div id="questions-container"></div>

<script src="{{ asset('js/quiz/question.js') }}"></script>
<script>
    async function load() {
        let res = await loadQuestions({{$quiz_id}});
        renderQuestions(res);
    }
    load();
</script>
@endsection
