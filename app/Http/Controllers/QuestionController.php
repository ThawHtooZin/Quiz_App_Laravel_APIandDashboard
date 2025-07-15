<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Question;
use App\Models\Option;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index(Quiz $quiz)
    {
        $questions = $quiz->questions()->with('options')->get();
        
        return view('questions.index', compact('quiz', 'questions'));
    }

    public function create(Quiz $quiz)
    {
        return view('questions.create', compact('quiz'));
    }

    public function store(Request $request, Quiz $quiz)
    {
        $validated = $request->validate([
            'question_text' => 'required|string',
            'options' => 'required|array|min:2',
            'options.*.text' => 'required|string|max:255',
            'correct_option' => 'required|integer|min:0',
        ]);

        $question = $quiz->questions()->create([
            'question_text' => $validated['question_text'],
        ]);

        foreach ($validated['options'] as $index => $optionData) {
            $question->options()->create([
                'text' => $optionData['text'],
                'is_correct' => $index == $validated['correct_option'],
            ]);
        }

        return redirect()->route('quizzes.questions.index', $quiz)
            ->with('success', 'Question added successfully!');
    }

    public function edit(Quiz $quiz, Question $question)
    {
        $question->load('options');
        
        return view('questions.edit', compact('quiz', 'question'));
    }

    public function update(Request $request, Quiz $quiz, Question $question)
    {
        $validated = $request->validate([
            'question_text' => 'required|string',
            'options' => 'required|array|min:2',
            'options.*.text' => 'required|string|max:255',
            'correct_option' => 'required|integer|min:0',
        ]);

        $question->update([
            'question_text' => $validated['question_text'],
        ]);

        // Delete existing options
        $question->options()->delete();

        // Create new options
        foreach ($validated['options'] as $index => $optionData) {
            $question->options()->create([
                'text' => $optionData['text'],
                'is_correct' => $index == $validated['correct_option'],
            ]);
        }

        return redirect()->route('quizzes.questions.index', $quiz)
            ->with('success', 'Question updated successfully!');
    }

    public function destroy(Quiz $quiz, Question $question)
    {
        $question->delete();

        return redirect()->route('quizzes.questions.index', $quiz)
            ->with('success', 'Question deleted successfully!');
    }
}
