<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'learning_path_id',
        'passing_score',
        'max_attempts',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'passing_score' => 'integer',
        'max_attempts' => 'integer',
    ];

    public function learningPath(): BelongsTo
    {
        return $this->belongsTo(LearningPath::class);
    }

    public function questions(): HasMany
    {
        return $this->hasMany(QuizQuestion::class)->orderBy('order');
    }

    public function userAttempts(): HasMany
    {
        return $this->hasMany(UserQuizAttempt::class);
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function getTotalQuestionsAttribute(): int
    {
        return $this->questions()->count();
    }

    public function getMaxPointsAttribute(): int
    {
        return $this->questions()->sum('points');
    }
}
