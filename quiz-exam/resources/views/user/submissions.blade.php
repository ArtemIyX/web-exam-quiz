@extends('layout')
@section('title', 'Submissions')

@section('content')
<div>
    <div id="results"></div>
    <div id="pagination"></div>
</div>

@endsection

@section('scripts')
<script src="{{ asset('js/quiz/submissions.js') }}"></script>
<script src="{{asset('js/quiz/loadQuizzes.js')}}"></script>
<script>

    function makeHtml(element) {
        const quizId = element.quiz.id;
        const submissionId = element.sub.id;
        const quizTitle = element.quiz.title;
        const submissionDate = new Date(element.sub.created_at);

        const html =  `
        <div>
            <a href="/quiz/${quizId}">${quizTitle}</a>
            <a href="/quiz/result/${submissionId}">${submissionDate.toDateString()}</a>
        </div>
        <br>
        `;
        return html;
    }

    async function load() {

        const submissions = await getSubmissions({{$user->id}});
        const quizIds = submissions.map(result => result.quiz_id);
        const waitQuiz = quizIds.map(id => getQuiz(id));
        const quizes = await Promise.all(waitQuiz);

        const res = [];
        submissions.forEach(element => {
            res.push({
                sub: element,
                quiz: quizes.find(x => x.id == element.quiz_id)
            });
        });
        const h = [];
        res.forEach(element => {
            h.push(makeHtml(element));
        });

        savedData = h;
        displayResults();
    }
    load();

</script>

@endsection
