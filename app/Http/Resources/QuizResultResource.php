<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuizResultResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'quiz' => [
                'id' => $this->quiz->id,
                'title' => $this->quiz->title,
                'description' => $this->quiz->description,
            ],
            'score' => $this->score,
            'total_questions' => $this->quiz->questions_count ?? 0,
            'percentage' => $this->percentage,
            'time_taken' => $this->time_taken,
            'formatted_time' => $this->formatted_time,
            'attempted_at' => $this->created_at,
        ];
    }
}
