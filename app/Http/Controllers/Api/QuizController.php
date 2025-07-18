<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\QuizResource;
use App\Http\Resources\QuizDetailResource;
use App\Models\Quiz;
use App\Models\QuizResult;
use App\Models\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::where('is_published', true)
            ->withCount('questions')
            ->get();

        return QuizResource::collection($quizzes);
    }

    public function show(Quiz $quiz)
    {
        if (!$quiz->is_published) {
            return response()->json([
                'message' => 'Quiz not found or not published.',
            ], 404);
        }

        $quiz->load(['questions.options']);

        return new QuizDetailResource($quiz);
    }

    public function submit(Request $request, Quiz $quiz)
    {
        if (!$quiz->is_published) {
            return response()->json([
                'message' => 'Quiz not found or not published.',
            ], 404);
        }

        $request->validate([
            'answers' => 'required|array',
            'answers.*.question_id' => 'required|exists:questions,id',
            'answers.*.selected_option_id' => 'required|exists:options,id',
            'time_taken' => 'nullable|integer|min:0',
        ]);

        // Users can now retake quizzes - no restriction check needed

        // Calculate score based on user's answers
        $score = 0;
        $answeredQuestionsCount = 0;
        
        foreach ($request->answers as $answer) {
            // Get the specific question and its options
            $question = $quiz->questions()->with('options')->find($answer['question_id']);
            if ($question) {
                $answeredQuestionsCount++;
                $selectedOption = $question->options->find($answer['selected_option_id']);
                if ($selectedOption && $selectedOption->is_correct) {
                    $score++;
                }
            }
        }

        // Create quiz result
        $quizResult = QuizResult::create([
            'user_id' => Auth::id(),
            'quiz_id' => $quiz->id,
            'score' => $score,
            'time_taken' => $request->time_taken,
            'questions_answered' => $answeredQuestionsCount,
        ]);

        // Record answers
        foreach ($request->answers as $answer) {
            Answer::create([
                'quiz_result_id' => $quizResult->id,
                'question_id' => $answer['question_id'],
                'selected_option_id' => $answer['selected_option_id'],
            ]);
        }

        return response()->json([
            'message' => 'Quiz submitted successfully',
            'result' => [
                'id' => $quizResult->id,
                'score' => $score,
                'total_questions' => $answeredQuestionsCount,
                'percentage' => round(($score / $answeredQuestionsCount) * 100, 2),
                'time_taken' => $request->time_taken,
            ],
        ], 201);
    }
}
