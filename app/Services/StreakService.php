<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserStreak;
use Carbon\Carbon;

class StreakService
{
    public function getOrCreateStreak(User $user): UserStreak
    {
        return $user->streak()->firstOrCreate(
            ['user_id' => $user->id],
            [
                'current_streak' => 0,
                'longest_streak' => 0,
                'last_activity_date' => null,
                'streak_started_at' => null,
            ]
        );
    }

    public function recordActivity(User $user): UserStreak
    {
        $streak = $this->getOrCreateStreak($user);
        $streak->recordActivity();
        return $streak->fresh();
    }

    public function checkStreak(User $user): UserStreak
    {
        $streak = $this->getOrCreateStreak($user);
        $streak->checkAndResetStreak();
        return $streak->fresh();
    }

    public function getCurrentStreak(User $user): int
    {
        $streak = $this->getOrCreateStreak($user);
        return $streak->current_streak;
    }

    public function getLongestStreak(User $user): int
    {
        $streak = $this->getOrCreateStreak($user);
        return $streak->longest_streak;
    }

    public function isStreakActive(User $user): bool
    {
        $streak = $this->getOrCreateStreak($user);
        return $streak->isStreakActive();
    }

    public function hasVisitedToday(User $user): bool
    {
        $streak = $this->getOrCreateStreak($user);
        
        if ($streak->last_activity_date === null) {
            return false;
        }

        return Carbon::parse($streak->last_activity_date)->isToday();
    }

    public function getStreakStatus(User $user): array
    {
        $streak = $this->getOrCreateStreak($user);
        
        return [
            'current_streak' => $streak->current_streak,
            'longest_streak' => $streak->longest_streak,
            'has_visited_today' => $this->hasVisitedToday($user),
            'is_active' => $streak->isStreakActive(),
            'days_until_break' => $streak->isStreakActive() ? 1 : 0,
        ];
    }
}
