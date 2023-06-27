<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Quiz;
use App\Services\QuizService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class QuizController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::all()->take(20);

        return response()->json([
            'retCode' => 0,
            'retMsg' => 'OK',
            'result' => $quizzes
        ]);
    }

    public function questions($id)
    {
        try {
            $quiz = Quiz::findOrFail($id);
            $questions = $quiz->questions;
            return response()->json([
                'retCode' => 0,
                'retMsg' => 'OK',
                'result' => $questions
            ]);
        }
        catch(ModelNotFoundException $e) {
            return response()->json([
                'retCode' => 404,
                'retMsg' => 'NOT FOUND',
                'result' => null
            ]);
        }
    }
    public function options($id)
    {
        try {
            $question = Question::findOrFail($id);
            $options = $question->options;
            for($i = 0; $i < count($options); $i++) {
                $options[$i]->makeHidden('is_correct');
            }
            return response()->json([
                'retCode' => 0,
                'retMsg' => 'OK',
                'result' => $options
            ]);
        }
        catch(ModelNotFoundException $e) {
            return response()->json([
                'retCode' => 404,
                'retMsg' => 'NOT FOUND',
                'result' => null
            ]);
        }
    }


    public function details($id) {
        $quiz = Quiz::findOrFail($id);
        $quizDetails = (object) [
            'id' => $id,
            'title' => $quiz->title,
            'description' => $quiz->description,
            'author_name' => $quiz->author->name,
            'questions_count' => $quiz->questions->count(),
            'times_passed' => $quiz->times_passed
        ];
        return view('quiz/details', ['quizDetails' => $quizDetails]);
    }

    public function take($quiz_id) {
        return view('quiz/question', ['quiz_id' => $quiz_id]);
    }
    public function storeAnswer($quiz_id, $question_id) {

    }
}
