<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'time_limit',
        'is_published',
        'question_limit',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'time_limit' => 'integer',
        'question_limit' => 'integer',
    ];

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    public function quizResults(): HasMany
    {
        return $this->hasMany(QuizResult::class);
    }

    public function getAverageScoreAttribute()
    {
        if ($this->quizResults()->count() === 0) {
            return 0;
        }
        
        return round($this->quizResults()->avg('score'), 2);
    }

    public function getTotalAttemptsAttribute()
    {
        return $this->quizResults()->count();
    }

    public function getQuestionsCountAttribute()
    {
        return $this->questions()->count();
    }
}
