<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Services\ProgressService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

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

        $resources = $query->orderBy('category')
            ->orderBy('difficulty_level')
            ->paginate(12);

        $categories = Resource::active()->distinct()->pluck('category');

        if ($request->user()) {
            $completedIds = $request->user()->progress()
                ->where('is_completed', true)
                ->pluck('resource_id')
                ->toArray();
        } else {
            $completedIds = [];
        }

        return view('resources.index', compact('resources', 'categories', 'completedIds'));
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
