<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\QuizResultResource;
use App\Models\QuizResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizResultController extends Controller
{
    public function index(Request $request)
    {
        $results = QuizResult::where('user_id', Auth::id())
            ->with(['quiz'])
            ->latest()
            ->paginate(10);

        return QuizResultResource::collection($results);
    }

    public function show(QuizResult $result)
    {
        // Ensure user can only view their own results
        if ($result->user_id !== Auth::id()) {
            return response()->json([
                'message' => 'Unauthorized access to result.',
            ], 403);
        }

        $result->load([
            'quiz.questions.options',
            'answers.selectedOption',
            'answers.question.options'
        ]);

        $detailedResult = [
            'id' => $result->id,
            'quiz' => [
                'id' => $result->quiz->id,
                'title' => $result->quiz->title,
                'description' => $result->quiz->description,
            ],
            'score' => $result->score,
            'total_questions' => $result->questions_answered ?: $result->quiz->questions->count(),
            'percentage' => $result->percentage,
            'time_taken' => $result->time_taken,
            'formatted_time' => $result->formatted_time,
            'attempted_at' => $result->created_at,
            'questions' => [],
        ];

        // Build detailed question analysis - only show questions that were actually answered
        foreach ($result->answers as $answer) {
            $question = $answer->question;
            $selectedOption = $answer->selectedOption;
            $correctOption = $question->options->where('is_correct', true)->first();

            $detailedResult['questions'][] = [
                'id' => $question->id,
                'question_text' => $question->question_text,
                'selected_answer' => [
                    'id' => $selectedOption->id,
                    'text' => $selectedOption->text,
                    'is_correct' => $selectedOption->is_correct,
                ],
                'correct_answer' => [
                    'id' => $correctOption->id,
                    'text' => $correctOption->text,
                ],
                'is_correct' => $selectedOption->is_correct,
            ];
        }

        return response()->json($detailedResult);
    }
}
