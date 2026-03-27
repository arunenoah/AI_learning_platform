<?php

namespace App\Http\Controllers;

use App\Services\ProgressService;
use App\Services\BadgeService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

class ProgressController extends Controller
{
    protected ProgressService $progressService;
    protected BadgeService $badgeService;

    public function __construct(ProgressService $progressService, BadgeService $badgeService)
    {
        $this->progressService = $progressService;
        $this->badgeService = $badgeService;
    }

    public function profile(Request $request): View
    {
        $user = $request->user();
        $stats = $this->progressService->getUserStats($user);
        $badges = $this->badgeService->getUserBadges($user);
        
        $recentActivity = $user->progress()
            ->with('resource')
            ->where('is_completed', true)
            ->latest('completed_at')
            ->limit(10)
            ->get();

        $quizAttempts = $user->quizAttempts()
            ->with('quiz')
            ->latest('completed_at')
            ->limit(5)
            ->get();

        $pathProgress = $user->pathProgress()
            ->with('learningPath')
            ->get();

        return view('profile', compact(
            'user',
            'stats',
            'badges',
            'recentActivity',
            'quizAttempts',
            'pathProgress'
        ));
    }

    public function leaderboard(): View
    {
        $topUsers = \App\Models\User::orderByDesc('points')
            ->limit(20)
            ->get(['id', 'name', 'points', 'avatar']);

        $userRank = null;
        if (auth()->check()) {
            $userRank = \App\Models\User::where('points', '>', auth()->user()->points)->count() + 1;
        }

        return view('leaderboard', compact('topUsers', 'userRank'));
    }

    public function badges(Request $request): View
    {
        $user = $request->user();
        $earnedBadges = $this->badgeService->getUserBadges($user);
        $unearnedBadges = $this->badgeService->getUnearnedBadges($user);

        $badgesWithProgress = $unearnedBadges->map(function ($badge) use ($user) {
            $progress = $this->badgeService->getBadgeProgress($user, $badge);
            return [
                'badge' => $badge,
                'progress' => $progress,
            ];
        });

        return view('badges', compact('earnedBadges', 'badgesWithProgress'));
    }

    public function stats(Request $request): JsonResponse
    {
        $stats = $this->progressService->getUserStats($request->user());
        return response()->json($stats);
    }
}
