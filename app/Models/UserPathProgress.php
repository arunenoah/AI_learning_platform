<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserPathProgress extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'learning_path_id',
        'is_started',
        'is_completed',
        'started_at',
        'completed_at',
        'current_step',
    ];

    protected $casts = [
        'is_started' => 'boolean',
        'is_completed' => 'boolean',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'current_step' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function learningPath(): BelongsTo
    {
        return $this->belongsTo(LearningPath::class);
    }

    public function markAsStarted(): void
    {
        if (!$this->is_started) {
            $this->update([
                'is_started' => true,
                'started_at' => now(),
            ]);
        }
    }

    public function markAsCompleted(): void
    {
        $this->update([
            'is_completed' => true,
            'completed_at' => now(),
        ]);
    }

    public function advanceStep(): void
    {
        $this->increment('current_step');
    }

    public function getProgressPercentage(int $totalSteps): int
    {
        if ($totalSteps === 0) return 0;
        return (int) round(($this->current_step / $totalSteps) * 100);
    }
}
