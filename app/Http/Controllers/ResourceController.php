<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Services\ProgressService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ResourceController extends Controller
{
    protected ProgressService $progressService;

    public function __construct(ProgressService $progressService)
    {
        $this->progressService = $progressService;
    }

    public function index(Request $request): View
    {
        $query = Resource::active();

        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        if ($request->filled('difficulty')) {
            $query->where('difficulty_level', $request->difficulty);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $categoryOrder = [
            'Claude Code' => 1,
            'Claude API' => 2,
            'Claude Agent SDK' => 3,
            'MCP' => 4,
            'Prompt Engineering' => 5,
            'AI Agents' => 6,
            'AI Coding' => 7,
            'AI Frameworks' => 8,
            'Inference Tools' => 9,
            'ML Foundations' => 10,
            'Deep Learning' => 11,
            'LLMs' => 12,
            'Reinforcement Learning' => 13,
            'MLOps' => 14,
            'Google AI' => 15,
            'CS Fundamentals' => 16,
            'Free Textbooks' => 17,
            'YouTube' => 18,
            'AI News' => 19,
        ];

        $resources = $query
            ->orderByRaw('CASE 
                WHEN difficulty_level = 1 THEN 0 
                WHEN difficulty_level = 2 THEN 1 
                ELSE 2 
            END')
            ->orderByRaw('CASE 
                '.collect($categoryOrder)->map(fn ($order, $cat) => "WHEN category = '$cat' THEN $order")->implode(' ').' 
                ELSE 100 
            END')
            ->orderBy('title')
            ->paginate(12);

        $categories = Resource::active()->distinct()->pluck('category');
        $categoryCounts = Resource::active()
            ->select('category')
            ->selectRaw('COUNT(*) as count')
            ->groupBy('category')
            ->pluck('count', 'category');

        if ($request->user()) {
            $completedIds = $request->user()->progress()
                ->where('is_completed', true)
                ->pluck('resource_id')
                ->toArray();
        } else {
            $completedIds = [];
        }

        return view('resources.index', compact('resources', 'categories', 'categoryCounts', 'completedIds'));
    }

    public function show(Request $request, Resource $resource): View
    {
        if ($request->user()) {
            $this->progressService->recordResourceVisit($request->user(), $resource);
        }

        $isCompleted = $request->user()
            ? $request->user()->progress()->where('resource_id', $resource->id)->where('is_completed', true)->exists()
            : false;

        return view('resources.show', compact('resource', 'isCompleted'));
    }

    public function complete(Request $request, Resource $resource): JsonResponse
    {
        $this->progressService->completeResource($request->user(), $resource);

        return response()->json([
            'success' => true,
            'message' => 'Resource completed!',
            'points_earned' => 25,
        ]);
    }
}
