<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserQuizAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'quiz_id',
        'score',
        'total_questions',
        'correct_answers',
        'passed',
        'answers',
        'completed_at',
    ];

    protected $casts = [
        'score' => 'integer',
        'total_questions' => 'integer',
        'correct_answers' => 'integer',
        'passed' => 'boolean',
        'answers' => 'array',
        'completed_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    public function calculateScore(): int
    {
        if ($this->total_questions === 0) return 0;
        return (int) round(($this->correct_answers / $this->total_questions) * 100);
    }

    public function isPassed(int $passingScore): bool
    {
        return $this->score >= $passingScore;
    }
}
