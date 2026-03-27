<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class UserStreak extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'current_streak',
        'longest_streak',
        'last_activity_date',
        'streak_started_at',
    ];

    protected $casts = [
        'current_streak' => 'integer',
        'longest_streak' => 'integer',
        'last_activity_date' => 'date',
        'streak_started_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function recordActivity(): void
    {
        $today = Carbon::today();

        if ($this->last_activity_date === null) {
            $this->update([
                'current_streak' => 1,
                'last_activity_date' => $today,
                'streak_started_at' => now(),
            ]);
            return;
        }

        $lastActivity = Carbon::parse($this->last_activity_date);
        $daysDiff = $lastActivity->diffInDays($today);

        if ($daysDiff === 0) {
            return;
        }

        if ($daysDiff === 1) {
            $this->increment('current_streak');
            if ($this->current_streak > $this->longest_streak) {
                $this->update(['longest_streak' => $this->current_streak]);
            }
        } else {
            $this->update([
                'current_streak' => 1,
                'streak_started_at' => now(),
            ]);
        }

        $this->update(['last_activity_date' => $today]);
    }

    public function checkAndResetStreak(): void
    {
        if ($this->last_activity_date === null) {
            return;
        }

        $today = Carbon::today();
        $lastActivity = Carbon::parse($this->last_activity_date);

        if ($lastActivity->diffInDays($today) > 1) {
            $this->update(['current_streak' => 0]);
        }
    }

    public function isStreakActive(): bool
    {
        if ($this->last_activity_date === null) {
            return false;
        }

        $today = Carbon::today();
        $lastActivity = Carbon::parse($this->last_activity_date);

        return $lastActivity->diffInDays($today) <= 1;
    }
}
