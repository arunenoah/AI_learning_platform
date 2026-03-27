<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserProgress extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'resource_id',
        'is_completed',
        'completed_at',
        'time_spent_minutes',
    ];

    protected $casts = [
        'is_completed' => 'boolean',
        'completed_at' => 'datetime',
        'time_spent_minutes' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function resource(): BelongsTo
    {
        return $this->belongsTo(Resource::class);
    }

    public function markAsCompleted(): void
    {
        $this->update([
            'is_completed' => true,
            'completed_at' => now(),
        ]);
    }

    public function addTime(int $minutes): void
    {
        $this->increment('time_spent_minutes', $minutes);
    }
}
