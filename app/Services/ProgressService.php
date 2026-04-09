<?php

namespace App\Services;

use App\Models\Badge;
use App\Models\LearningPath;
use App\Models\Quiz;
use App\Models\Resource;
use App\Models\User;
use App\Models\UserPathProgress;
use App\Models\UserProgress;
use App\Models\UserQuizAttempt;
use Illuminate\Support\Facades\DB;

class ProgressService
{
    protected StreakService $streakService;

    protected BadgeService $badgeService;

    protected PointsService $pointsService;

    public function __construct(
        StreakService $streakService,
        BadgeService $badgeService,
        PointsService $pointsService
    ) {
        $this->streakService = $streakService;
        $this->badgeService = $badgeService;
        $this->pointsService = $pointsService;
    }

    public function recordResourceVisit(User $user, Resource $resource): UserProgress
    {
        $this->streakService->recordActivity($user);
        $this->pointsService->recordResourceVisit($user);

        $progress = $user->progress()->firstOrCreate(
            ['resource_id' => $resource->id],
            ['user_id' => $user->id]
        );

        return $progress;
    }

    public function completeResource(User $user, Resource $resource): UserProgress
    {
        $this->streakService->recordActivity($user);
        $this->pointsService->recordResourceComplete($user);

        $progress = $user->progress()->updateOrCreate(
            ['resource_id' => $resource->id],
            [
                'is_completed' => true,
                'completed_at' => now(),
            ]
        );

        $this->checkDailyChallengeBonus($user, $resource);
        $this->checkPathProgress($user, $resource);
        $this->badgeService->checkAndAwardBadges($user);

        return $progress;
    }

    protected function checkDailyChallengeBonus(User $user, Resource $resource): void
    {
        $today = now()->toDateString();
        $challenge = DailyChallenge::where('challenge_date', $today)->first();

        if ($challenge && $challenge->resource_id == $resource->id) {
            $this->pointsService->addPoints($user, $challenge->bonus_xp, 'Daily challenge completed');
        }
    }

    public function startPath(User $user, LearningPath $path): UserPathProgress
    {
        $this->streakService->recordActivity($user);
        $this->pointsService->recordPathStart($user);

        $progress = $user->pathProgress()->firstOrCreate(
            ['learning_path_id' => $path->id],
            [
                'is_started' => true,
                'started_at' => now(),
                'current_step' => 0,
            ]
        );

        if (! $progress->wasRecentlyCreated) {
            $progress->markAsStarted();
        }

        return $progress;
    }

    public function completeStep(User $user, LearningPath $path, int $stepNumber): UserPathProgress
    {
        $this->streakService->recordActivity($user);

        $progress = $user->pathProgress()->firstOrCreate(
            ['learning_path_id' => $path->id],
            [
                'is_started' => true,
                'started_at' => now(),
                'current_step' => 0,
            ]
        );

        $totalSteps = $path->total_steps;

        if ($stepNumber >= $totalSteps - 1) {
            $progress->update([
                'current_step' => $totalSteps,
                'is_completed' => true,
                'completed_at' => now(),
            ]);
            $this->pointsService->recordPathComplete($user);
        } else {
            $progress->update(['current_step' => $stepNumber + 1]);
        }

        $this->badgeService->checkAndAwardBadges($user);

        return $progress->fresh();
    }

    protected function checkPathProgress(User $user, Resource $resource): void
    {
        $pathsContainingResource = LearningPath::whereHas('steps', function ($query) use ($resource) {
            $query->where('resource_id', $resource->id);
        })->get();

        foreach ($pathsContainingResource as $path) {
            $progress = $user->pathProgress()
                ->where('learning_path_id', $path->id)
                ->where('is_started', true)
                ->first();

            if ($progress) {
                $completedResources = $user->progress()
                    ->whereIn('resource_id', $path->steps->pluck('resource_id'))
                    ->where('is_completed', true)
                    ->count();

                $totalSteps = $path->total_steps;

                if ($completedResources >= $totalSteps) {
                    $progress->markAsCompleted();
                    $this->pointsService->recordPathComplete($user);
                }
            }
        }
    }

    public function submitQuiz(User $user, Quiz $quiz, array $answers): UserQuizAttempt
    {
        return DB::transaction(function () use ($user, $quiz, $answers) {
            $this->streakService->recordActivity($user);
            $this->pointsService->recordQuizAttempt($user);

            $questions = $quiz->questions;
            $correctCount = 0;
            $totalPoints = 0;
            $earnedPoints = 0;

            foreach ($questions as $question) {
                $totalPoints += $question->points;
                if (isset($answers[$question->id]) && $answers[$question->id] === $question->correct_option) {
                    $correctCount++;
                    $earnedPoints += $question->points;
                }
            }

            $score = $totalPoints > 0 ? round(($earnedPoints / $totalPoints) * 100) : 0;
            $passed = $score >= $quiz->passing_score;
            $isPerfect = $correctCount === $questions->count() && $questions->count() > 0;

            $attempt = $user->quizAttempts()->create([
                'quiz_id' => $quiz->id,
                'score' => $score,
                'total_questions' => $questions->count(),
                'correct_answers' => $correctCount,
                'passed' => $passed,
                'answers' => $answers,
                'completed_at' => now(),
            ]);

            if ($passed) {
                $this->pointsService->recordQuizPass($user, $isPerfect);
            }

            $this->badgeService->checkAndAwardBadges($user);

            return $attempt;
        });
    }

    public function getUserStats(User $user): array
    {
        return [
            'points' => $this->pointsService->getUserPoints($user),
            'level_info' => $this->pointsService->getLevelProgress($user->points),
            'streak' => $this->streakService->getStreakStatus($user),
            'resources_completed' => $user->completedResources()->count(),
            'paths_completed' => $user->completedPaths()->count(),
            'quizzes_passed' => $user->passedQuizzes()->count(),
            'badges_count' => $user->badges()->count(),
            'total_badges' => Badge::count(),
        ];
    }
}
