<?php

namespace App\Http\Controllers;

use App\Models\LearningPath;
use App\Services\ProgressService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

class LearningPathController extends Controller
{
    protected ProgressService $progressService;

    public function __construct(ProgressService $progressService)
    {
        $this->progressService = $progressService;
    }

    public function index(Request $request): View
    {
        $paths = LearningPath::published()
            ->orderBy('order')
            ->withCount('steps')
            ->get();

        if ($request->user()) {
            $progressData = [];
            foreach ($paths as $path) {
                $progress = $request->user()->pathProgress()
                    ->where('learning_path_id', $path->id)
                    ->first();
                
                $progressData[$path->id] = [
                    'is_started' => $progress ? $progress->is_started : false,
                    'is_completed' => $progress ? $progress->is_completed : false,
                    'current_step' => $progress ? $progress->current_step : 0,
                    'percentage' => $progress ? $progress->getProgressPercentage($path->steps_count) : 0,
                ];
            }
        } else {
            $progressData = [];
        }

        return view('paths.index', compact('paths', 'progressData'));
    }

    public function show(Request $request, LearningPath $path): View
    {
        $path->load(['steps.resource']);

        if ($request->user()) {
            $progress = $request->user()->pathProgress()
                ->where('learning_path_id', $path->id)
                ->first();
            
            $completedResourceIds = $request->user()->progress()
                ->where('is_completed', true)
                ->pluck('resource_id')
                ->toArray();
        } else {
            $progress = null;
            $completedResourceIds = [];
        }

        $totalSteps = $path->steps->count();
        $currentStep = $progress ? $progress->current_step : 0;
        $percentage = $progress ? $progress->getProgressPercentage($totalSteps) : 0;

        return view('paths.show', compact(
            'path', 
            'progress', 
            'completedResourceIds',
            'totalSteps',
            'currentStep',
            'percentage'
        ));
    }

    public function start(Request $request, LearningPath $path): JsonResponse
    {
        $progress = $this->progressService->startPath($request->user(), $path);
        
        return response()->json([
            'success' => true,
            'message' => 'Learning path started!',
            'progress' => [
                'is_started' => true,
                'started_at' => $progress->started_at,
            ],
        ]);
    }

    public function completeStep(Request $request, LearningPath $path, int $step): JsonResponse
    {
        $progress = $this->progressService->completeStep($request->user(), $path, $step);
        
        $isCompleted = $progress->is_completed;
        $pointsEarned = $isCompleted ? 100 : 10;

        return response()->json([
            'success' => true,
            'message' => $isCompleted ? 'Learning path completed!' : 'Step completed!',
            'progress' => [
                'current_step' => $progress->current_step,
                'is_completed' => $isCompleted,
                'percentage' => $progress->getProgressPercentage($path->total_steps),
            ],
            'points_earned' => $pointsEarned,
        ]);
    }
}
