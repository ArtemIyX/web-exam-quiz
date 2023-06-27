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
}
