<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Answer extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_result_id',
        'question_id',
        'selected_option_id',
    ];

    public function quizResult(): BelongsTo
    {
        return $this->belongsTo(QuizResult::class);
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    public function selectedOption(): BelongsTo
    {
        return $this->belongsTo(Option::class, 'selected_option_id');
    }

    public function getIsCorrectAttribute()
    {
        return $this->selectedOption->is_correct;
    }
}
