<?php

namespace App\Services;
use App\Models\Quiz;

class QuizService
{
    public function getAllQuizzes()
    {
        return Quiz::all();
    }
    public function getQuizById($quizId)
    {
        return Quiz::findOrFail($quizId);
    }
    public function getQuestionsForQuiz($quizId)
    {
        $quiz = Quiz::findOrFail($quizId);
        return $quiz->questions;
    }
    public function createQuizWithQuestions($quizData, $questionsData)
    {
        $quiz = Quiz::create($quizData);

        foreach ($questionsData as $questionData) {
            $quiz->questions()->create($questionData);
        }

        return $quiz;
    }
}
