<?php

namespace App\Services;

use App\Models\User;

class PointsService
{
    public const POINTS_RESOURCE_VISIT = 5;
    public const POINTS_RESOURCE_COMPLETE = 25;
    public const POINTS_PATH_START = 10;
    public const POINTS_PATH_COMPLETE = 100;
    public const POINTS_QUIZ_ATTEMPT = 15;
    public const POINTS_QUIZ_PASS = 50;
    public const POINTS_PERFECT_QUIZ = 75;
    public const POINTS_STREAK_DAY = 10;
    public const POINTS_BADGE = 25;

    public function addPoints(User $user, int $points, string $reason = null): int
    {
        $user->increment('points', $points);
        return $user->points;
    }

    public function recordResourceVisit(User $user): int
    {
        return $this->addPoints($user, self::POINTS_RESOURCE_VISIT, 'Resource visited');
    }

    public function recordResourceComplete(User $user): int
    {
        return $this->addPoints($user, self::POINTS_RESOURCE_COMPLETE, 'Resource completed');
    }

    public function recordPathStart(User $user): int
    {
        return $this->addPoints($user, self::POINTS_PATH_START, 'Learning path started');
    }

    public function recordPathComplete(User $user): int
    {
        return $this->addPoints($user, self::POINTS_PATH_COMPLETE, 'Learning path completed');
    }

    public function recordQuizAttempt(User $user): int
    {
        return $this->addPoints($user, self::POINTS_QUIZ_ATTEMPT, 'Quiz attempted');
    }

    public function recordQuizPass(User $user, bool $isPerfect = false): int
    {
        $points = $isPerfect 
            ? self::POINTS_QUIZ_PASS + self::POINTS_PERFECT_QUIZ 
            : self::POINTS_QUIZ_PASS;
        
        return $this->addPoints($user, $points, $isPerfect ? 'Perfect quiz score' : 'Quiz passed');
    }

    public function recordStreakDay(User $user, int $streakDays): int
    {
        $bonusPoints = min($streakDays * self::POINTS_STREAK_DAY, 100);
        return $this->addPoints($user, $bonusPoints, "{$streakDays} day streak");
    }

    public function getUserPoints(User $user): int
    {
        return $user->points ?? 0;
    }

    public function getPointsToNextLevel(int $currentPoints): int
    {
        $levels = [0, 100, 250, 500, 1000, 2000, 5000, 10000, 25000, 50000];
        
        foreach ($levels as $levelPoints) {
            if ($currentPoints < $levelPoints) {
                return $levelPoints - $currentPoints;
            }
        }
        
        return 0;
    }

    public function getUserLevel(int $points): int
    {
        $levels = [0, 100, 250, 500, 1000, 2000, 5000, 10000, 25000, 50000];
        
        $level = 1;
        foreach ($levels as $index => $threshold) {
            if ($points >= $threshold) {
                $level = $index + 2;
            }
        }
        
        return min($level, 10);
    }

    public function getLevelProgress(int $points): array
    {
        $levels = [0, 100, 250, 500, 1000, 2000, 5000, 10000, 25000, 50000];
        
        $currentLevel = 1;
        $currentThreshold = 0;
        $nextThreshold = $levels[0];

        foreach ($levels as $index => $threshold) {
            if ($points >= $threshold) {
                $currentLevel = $index + 1;
                $currentThreshold = $threshold;
                $nextThreshold = isset($levels[$index + 1]) ? $levels[$index + 1] : null;
            }
        }

        $progress = 0;
        if ($nextThreshold !== null) {
            $range = $nextThreshold - $currentThreshold;
            $current = $points - $currentThreshold;
            $progress = round(($current / $range) * 100);
        }

        return [
            'level' => min($currentLevel, 10),
            'current_points' => $points,
            'next_threshold' => $nextThreshold,
            'points_to_next' => $nextThreshold ? $nextThreshold - $points : 0,
            'progress_percentage' => $progress,
        ];
    }
}
