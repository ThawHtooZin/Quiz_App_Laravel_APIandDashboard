<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QuizResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'quiz_id',
        'score',
        'time_taken',
    ];

    protected $casts = [
        'score' => 'integer',
        'time_taken' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }

    public function getPercentageAttribute()
    {
        $totalQuestions = $this->quiz->questions()->count();
        if ($totalQuestions === 0) {
            return 0;
        }
        
        return round(($this->score / $totalQuestions) * 100, 2);
    }

    public function getFormattedTimeAttribute()
    {
        if (!$this->time_taken) {
            return 'N/A';
        }
        
        $minutes = floor($this->time_taken / 60);
        $seconds = $this->time_taken % 60;
        
        return sprintf('%02d:%02d', $minutes, $seconds);
    }
}
