<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\QuizResult;
use App\Models\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizAttemptController extends Controller
{
    public function start(Quiz $quiz)
    {
        if (!$quiz->is_published) {
            return redirect()->back()->with('error', 'This quiz is not available.');
        }

        if ($quiz->questions()->count() === 0) {
            return redirect()->back()->with('error', 'This quiz has no questions.');
        }

        return view('quiz-attempts.start', compact('quiz'));
    }

    public function take(Quiz $quiz)
    {
        if (!$quiz->is_published) {
            return redirect()->back()->with('error', 'This quiz is not available.');
        }

        $questionsQuery = $quiz->questions()->with('options');
        
        // Apply question pooling if question_limit is set
        if ($quiz->question_limit) {
            $questionsQuery = $questionsQuery->inRandomOrder()->take($quiz->question_limit);
        }
        
        $questions = $questionsQuery->get();
        
        if ($questions->count() === 0) {
            return redirect()->back()->with('error', 'This quiz has no questions.');
        }

        // Options are now in their original order (no shuffling)

        return view('quiz-attempts.take', compact('quiz', 'questions'));
    }

    public function submit(Request $request, Quiz $quiz)
    {
        $validated = $request->validate([
            'answers' => 'required|array',
            'answers.*' => 'required|exists:options,id',
            'time_taken' => 'nullable|integer|min:0',
        ]);

        $questionsQuery = $quiz->questions()->with('options');
        
        // Apply question pooling if question_limit is set (same as in take method)
        if ($quiz->question_limit) {
            $questionsQuery = $questionsQuery->inRandomOrder()->take($quiz->question_limit);
        }
        
        $questions = $questionsQuery->get();
        
        $score = 0;

        // Calculate score
        foreach ($questions as $question) {
            $selectedOptionId = $validated['answers'][$question->id] ?? null;
            if ($selectedOptionId) {
                $selectedOption = $question->options()->find($selectedOptionId);
                if ($selectedOption && $selectedOption->is_correct) {
                    $score++;
                }
            }
        }

        // Create quiz result (users can now retake quizzes)
        $quizResult = QuizResult::create([
            'user_id' => Auth::id(),
            'quiz_id' => $quiz->id,
            'score' => $score,
            'time_taken' => $validated['time_taken'] ?? null,
            'questions_answered' => $questions->count(),
        ]);

        // Record answers
        foreach ($validated['answers'] as $questionId => $optionId) {
            Answer::create([
                'quiz_result_id' => $quizResult->id,
                'question_id' => $questionId,
                'selected_option_id' => $optionId,
            ]);
        }

        return redirect()->route('quiz-attempts.result', $quizResult)
            ->with('success', 'Quiz submitted successfully!');
    }

    public function result(QuizResult $quizResult)
    {
        $quizResult->load(['quiz.questions.options', 'answers.selectedOption']);
        
        return view('quiz-attempts.result', compact('quizResult'));
    }

    public function history()
    {
        $results = QuizResult::with(['quiz'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('quiz-attempts.history', compact('results'));
    }
}
