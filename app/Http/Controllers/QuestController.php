<?php

namespace App\Http\Controllers;

use App\Models\LearningQuest;
use App\Models\UserQuestProgress;
use App\Services\PointsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class QuestController extends Controller
{
    protected PointsService $pointsService;

    public function __construct(PointsService $pointsService)
    {
        $this->pointsService = $pointsService;
    }

    public function complete(Request $request, LearningQuest $quest): JsonResponse
    {
        $user = $request->user();

        $existingProgress = UserQuestProgress::where('user_id', $user->id)
            ->where('learning_quest_id', $quest->id)
            ->first();

        if ($existingProgress && $existingProgress->is_completed) {
            return response()->json([
                'success' => false,
                'message' => 'Quest already completed',
            ]);
        }

        UserQuestProgress::updateOrCreate(
            [
                'user_id' => $user->id,
                'learning_quest_id' => $quest->id,
            ],
            [
                'is_completed' => true,
                'completed_at' => now(),
            ]
        );

        $this->pointsService->addPoints($user, $quest->xp_reward, 'Quest completed: '.$quest->title);

        return response()->json([
            'success' => true,
            'message' => 'Quest completed! +'.$quest->xp_reward.' XP',
            'xp_earned' => $quest->xp_reward,
        ]);
    }
}
