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

    public function questions($quiz_id)
    {
        try {
            $quiz = Quiz::findOrFail($quiz_id);
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
    public function options($quiz_id)
    {
        try {
            $question = Question::findOrFail($quiz_id);
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

    public function matches($quiz_id)
    {
        try {
            $question = Question::findOrFail($quiz_id);
            $macthes = $question->matches;
            for($i = 0; $i < count($macthes); $i++) {
                $macthes[$i]->makeHidden('parent_id');
            }
            $grouped = $macthes->groupBy('is_right');

            $result = [
                'left' => $grouped[false] ?? [],
                'right' => $grouped[true] ?? [],
            ];
            return response()->json([
                'retCode' => 0,
                'retMsg' => 'OK',
                'result' => $result
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


    public function details($quiz_id) {
        $quiz = Quiz::findOrFail($quiz_id);
        $quizDetails = (object) [
            'id' => $quiz_id,
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
