<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Models\LearningPath;
use App\Models\Quiz;
use App\Services\ProgressService;
use App\Services\BadgeService;
use App\Services\StreakService;
use App\Services\PointsService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    protected ProgressService $progressService;
    protected BadgeService $badgeService;
    protected StreakService $streakService;
    protected PointsService $pointsService;

    public function __construct(
        ProgressService $progressService,
        BadgeService $badgeService,
        StreakService $streakService,
        PointsService $pointsService
    ) {
        $this->progressService = $progressService;
        $this->badgeService = $badgeService;
        $this->streakService = $streakService;
        $this->pointsService = $pointsService;
    }

    public function index(Request $request): View
    {
        $user = $request->user();
        
        $stats = $this->progressService->getUserStats($user);
        $badges = $this->badgeService->getUserBadges($user);
        $unearnedBadges = $this->badgeService->getUnearnedBadges($user);
        $recentProgress = $user->progress()
            ->with('resource')
            ->where('is_completed', true)
            ->latest('completed_at')
            ->limit(5)
            ->get();
        
        $continuePaths = $user->pathProgress()
            ->where('is_started', true)
            ->where('is_completed', false)
            ->with('learningPath')
            ->limit(3)
            ->get();

        $suggestedResources = Resource::active()
            ->whereNotIn('id', $user->progress()->where('is_completed', true)->pluck('resource_id'))
            ->inRandomOrder()
            ->limit(4)
            ->get();

        return view('dashboard', compact(
            'stats',
            'badges',
            'unearnedBadges',
            'recentProgress',
            'continuePaths',
            'suggestedResources'
        ));
    }
}
