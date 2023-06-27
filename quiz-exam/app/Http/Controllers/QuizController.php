<?php

namespace App\Http\Controllers;

use App\Services\QuizService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class QuizController extends Controller
{
    public function index(QuizService $quizService)
    {
        $quizzes = $quizService->getAllQuizzes(20);

        return response()->json([
            'retCode' => 0,
            'retMsg' => 'OK',
            'result' => $quizzes
        ]);
    }

    public function details($id, QuizService $quizService) {
        $quiz = $quizService->getQuizById($id);
        $quizDetails = (object) [
            'title' => $quiz->title,
            'description' => $quiz->description,
            'author_name' => $quiz->author->name,
            'questions_count' => $quiz->questions->count(),
            'times_passed' => $quiz->times_passed
        ];
        return view('quiz/details', ['quizDetails' => $quizDetails]);
    }
}
