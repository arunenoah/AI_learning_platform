<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LearningQuest extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'type',
        'resource_id',
        'quiz_id',
        'xp_reward',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'xp_reward' => 'integer',
        'order' => 'integer',
    ];

    public function resource(): BelongsTo
    {
        return $this->belongsTo(Resource::class);
    }

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    public function userProgress(): HasMany
    {
        return $this->hasMany(UserQuestProgress::class, 'learning_quest_id');
    }

    public function isCompletedByUser($userId): bool
    {
        return $this->userProgress()
            ->where('user_id', $userId)
            ->where('is_completed', true)
            ->exists();
    }

    public function getTypeIcon(): string
    {
        return match ($this->type) {
            'play' => '🎮',
            'read' => '📖',
            'write' => '✏️',
            default => '⭐',
        };
    }

    public function getTypeLabel(): string
    {
        return match ($this->type) {
            'play' => 'Play & Explore',
            'read' => 'Read & Learn',
            'write' => 'Practice & Write',
            default => 'Learn',
        };
    }
}
