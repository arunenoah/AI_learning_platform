<?php

namespace App\Services;

use App\Models\User;
use App\Models\Badge;
use App\Models\UserBadge;
use Illuminate\Support\Collection;

class BadgeService
{
    protected PointsService $pointsService;

    public function __construct(PointsService $pointsService)
    {
        $this->pointsService = $pointsService;
    }

    public function checkAndAwardBadges(User $user): array
    {
        $newBadges = [];
        $earnedBadgeIds = $user->badges()->pluck('badges.id')->toArray();

        $eligibleBadges = $this->getEligibleBadges($user)
            ->filter(fn($badge) => !in_array($badge->id, $earnedBadgeIds));

        foreach ($eligibleBadges as $badge) {
            if ($this->awardBadge($user, $badge)) {
                $newBadges[] = $badge;
            }
        }

        return $newBadges;
    }

    public function getEligibleBadges(User $user): Collection
    {
        return Badge::all()->filter(function ($badge) use ($user) {
            return $this->meetsRequirement($user, $badge);
        });
    }

    public function meetsRequirement(User $user, Badge $badge): bool
    {
        return match ($badge->type) {
            'resources_completed' => $user->completedResources()->count() >= $badge->requirement_value,
            'paths_completed' => $user->completedPaths()->count() >= $badge->requirement_value,
            'quizzes_passed' => $user->passedQuizzes()->count() >= $badge->requirement_value,
            'streak_days' => $this->getStreakDays($user) >= $badge->requirement_value,
            'points_earned' => $user->points >= $badge->requirement_value,
            'perfect_quiz' => $this->hasPerfectQuiz($user),
            default => false,
        };
    }

    protected function getStreakDays(User $user): int
    {
        $streak = $user->streak()->first();
        return $streak ? $streak->current_streak : 0;
    }

    protected function hasPerfectQuiz(User $user): bool
    {
        return $user->quizAttempts()
            ->where('correct_answers', '>', 0)
            ->whereColumn('correct_answers', 'total_questions')
            ->exists();
    }

    public function awardBadge(User $user, Badge $badge): bool
    {
        if ($user->badges()->where('badge_id', $badge->id)->exists()) {
            return false;
        }

        UserBadge::create([
            'user_id' => $user->id,
            'badge_id' => $badge->id,
            'earned_at' => now(),
        ]);

        $points = $this->getBadgePoints($badge);
        if ($points > 0) {
            $user->increment('points', $points);
        }

        return true;
    }

    protected function getBadgePoints(Badge $badge): int
    {
        return match ($badge->slug) {
            'first-step', 'getting-started' => 10,
            'first-path', 'pathfinder' => 50,
            'streak-7', 'week-warrior' => 75,
            'streak-30', 'monthly-master' => 200,
            'perfect-quiz', 'perfectionist' => 100,
            'resources-10', 'knowledge-seeker' => 100,
            'resources-25', 'dedicated-learner' => 150,
            'resources-50', 'scholar' => 250,
            'all-paths', 'journey-completer' => 500,
            'points-1000', 'point-collector' => 0,
            default => 25,
        };
    }

    public function getUserBadges(User $user): Collection
    {
        return $user->badges()->orderByPivot('earned_at', 'desc')->get();
    }

    public function getUnearnedBadges(User $user): Collection
    {
        $earnedIds = $user->badges()->pluck('badges.id')->toArray();
        return Badge::whereNotIn('id', $earnedIds)->get();
    }

    public function getBadgeProgress(User $user, Badge $badge): array
    {
        $current = match ($badge->type) {
            'resources_completed' => $user->completedResources()->count(),
            'paths_completed' => $user->completedPaths()->count(),
            'quizzes_passed' => $user->passedQuizzes()->count(),
            'streak_days' => $this->getStreakDays($user),
            'points_earned' => $user->points,
            'perfect_quiz' => $this->hasPerfectQuiz($user) ? 1 : 0,
            default => 0,
        };

        return [
            'current' => $current,
            'required' => $badge->requirement_value,
            'percentage' => min(100, round(($current / $badge->requirement_value) * 100)),
        ];
    }
}
