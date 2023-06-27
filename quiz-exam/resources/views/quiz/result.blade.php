@extends('layout')
@section('title', 'Quiz Result')

@section('content')
<h1>Quiz Result</h1>
<h2>Quiz id {{$sub_id}}</h2>

<script src="{{ asset('js/quiz/question.js') }}"></script>
<script>
    async function load() {

    }
    load();
</script>
@endsection
