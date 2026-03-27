<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuizQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_id',
        'question',
        'options',
        'correct_option',
        'explanation',
        'points',
        'order',
    ];

    protected $casts = [
        'options' => 'array',
        'correct_option' => 'integer',
        'points' => 'integer',
        'order' => 'integer',
    ];

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    public function isCorrect(int $answer): bool
    {
        return $this->correct_option === $answer;
    }
}
