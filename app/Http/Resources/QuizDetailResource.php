<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuizDetailResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        // Get questions with options and apply question pooling if question_limit is set
        $questionsQuery = $this->questions()->with('options');
        
        if ($this->question_limit) {
            $questionsQuery = $questionsQuery->inRandomOrder()->take($this->question_limit);
        }
        
        $questions = $questionsQuery->get();
        
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'time_limit' => $this->time_limit,
            'question_limit' => $this->question_limit,
            'questions_count' => $questions->count(),
            'questions' => $questions->map(function ($question) {
                return [
                    'id' => $question->id,
                    'question_text' => $question->question_text,
                    'options' => $question->options->shuffle()->map(function ($option) {
                        return [
                            'id' => $option->id,
                            'text' => $option->text,
                            // Note: is_correct is intentionally excluded for security
                        ];
                    }),
                ];
            }),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
