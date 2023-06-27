<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Quiz;
use App\Models\Submission;
use App\Models\SubmissionMatch;
use App\Models\SubmissionOption;
use App\Services\QuizService;
use Exception;
use Illuminate\Broadcasting\Broadcasters\PusherBroadcaster;
use \Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Message;
class QuizController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::all()->take(20);

        return response()->json([
            'retCode' => Response::HTTP_OK,
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
                'retCode' => Response::HTTP_OK,
                'retMsg' => 'OK',
                'result' => $questions
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'retCode' => Response::HTTP_NOT_FOUND,
                'retMsg' => 'NOT FOUND',
                'result' => null
            ], Response::HTTP_NOT_FOUND);
        }
    }
    public function options($quiz_id)
    {
        try {
            $question = Question::findOrFail($quiz_id);
            $options = $question->options;
            for ($i = 0; $i < count($options); $i++) {
                $options[$i]->makeHidden('is_correct');
            }
            return response()->json([
                'retCode' => Response::HTTP_OK,
                'retMsg' => 'OK',
                'result' => $options
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'retCode' => Response::HTTP_NOT_FOUND,
                'retMsg' => 'NOT FOUND',
                'result' => null
            ], Response::HTTP_NOT_FOUND);
        }
    }

    public function matches($quiz_id)
    {
        try {
            $question = Question::findOrFail($quiz_id);
            $macthes = $question->matches;
            for ($i = 0; $i < count($macthes); $i++) {
                $macthes[$i]->makeHidden('parent_id');
            }
            $grouped = $macthes->groupBy('is_right');

            $result = [
                'left' => $grouped[false] ?? [],
                'right' => $grouped[true] ?? [],
            ];
            return response()->json([
                'retCode' => Response::HTTP_OK,
                'retMsg' => 'OK',
                'result' => $result
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'retCode' => Response::HTTP_NOT_FOUND,
                'retMsg' => 'NOT FOUND',
                'result' => null
            ], Response::HTTP_NOT_FOUND);
        }
    }


    public function details($quiz_id)
    {
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

    public function take($quiz_id)
    {
        $u = Auth::user();
        return view('quiz/question', ['quiz_id' => $quiz_id], ['user_id' => $u->id]);
    }

    protected function getQuiz($jsonData) : Quiz | null {
        $quiz_need_id = $jsonData['quiz_id'];
        try {
            return Quiz::findOrFail($quiz_need_id);
        } catch (ModelNotFoundException $e) {
            return null;
        }
    }

    protected function grabOptionAnswers($quiz, $submission, $answers_options, &$submission_options) : bool {
        for($i = 0; $i < count($answers_options); ++$i) {
            $current_answer = $answers_options[$i];
            $q_id = $current_answer['question_id'];
            $selected_id = $current_answer['selected_id'];
            if ($quiz->questions->contains('id', $q_id)) {
                $submissionOption = new SubmissionOption();
                $submissionOption->submission_id = $submission->id;
                $submissionOption->question_id = $q_id;
                $submissionOption->option_id = $selected_id;

                array_push($submission_options, $submissionOption);
            }
            else {
                return false;
            }
        }
        return true;
    }

    protected function grabMatchAnswers($quiz, $submission, $answers_matches, &$submission_matches) : bool {
        for($i = 0; $i < count($answers_matches); ++$i) {
            $current_answer = $answers_matches[$i];
            $q_id = $current_answer['question_id'];
            $left_id = $current_answer['left_id'];
            $right_id = $current_answer['right_id'];

            if($quiz->questions->contains('id', $q_id)) {
                $submissionMatch = new SubmissionMatch();
                $submissionMatch->submission_id = $submission->id;
                $submissionMatch->question_id = $q_id;
                $submissionMatch->left_match_id = $left_id;
                $submissionMatch->right_match_id = $right_id;

                array_push($submission_matches, $submissionMatch);
            }
            else {
                return false;
            }
        }
        return true;
    }

    public function storeAnswer(Request $request)
    {
        try {
            $jsonData = $request->json()->all();
            $user = Auth::user();
            if ($user->id != $jsonData['user_id']) {
                return response()->json([
                    'retCode' => Response::HTTP_UNAUTHORIZED,
                    'retMsg' => 'UNAUTHORIZED',
                    'result' => null
                ]);
            }
            $quiz = $this->getQuiz($jsonData);
            if($quiz == null) {
                return response()->json([
                    'retCode' => Response::HTTP_NOT_FOUND,
                    'retMsg' => 'Quiz {$quiz_need_id} - NOT FOUND',
                    'result' => null
                ]);
            }

            $submission = new Submission();
            $submission->user_id = $user->id;
            $submission->quiz_id = $quiz->id;
            $submission->save();

            // Save options
            $answers_options = $request['options'];

            $submission_options = [];
            if($this->grabOptionAnswers($quiz, $submission, $answers_options, $submission_options)) {
                // all is fine
            }
            else {
                $submission->delete();
                return response()->json([
                    'retCode' => Response::HTTP_BAD_REQUEST,
                    'retMsg' => 'Question {$q_id} doesnt belong to this quiz',
                    'result' => null
                ], Response::HTTP_BAD_REQUEST);
            }

            $submission->options()->saveMany($submission_options);

            // Save matches
            $answers_matches = $request['matches'];
            $submission_matches = [];

            if($this->grabMatchAnswers($quiz, $submission, $answers_matches, $submission_matches)) {
                // All is fine
            }
            else {
                $submission->delete();
                return response()->json([
                    'retCode' => Response::HTTP_BAD_REQUEST,
                    'retMsg' => 'Question {$q_id} doesnt belong to this quiz',
                    'result' => null
                ], Response::HTTP_BAD_REQUEST);
            }
            $submission->matches()->saveMany($submission_matches);

            $submission->save();
            return response()->json([
                'retCode' => Response::HTTP_OK,
                'retMsg' => 'OK',
                'result' => $submission->id
            ]);
        }
        catch(Exception $ex) {
            return response()->json([
                'retCode' => Response::HTTP_BAD_REQUEST,
                'retMsg' => $ex->getMessage(),
                'result' => null
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
