@extends('layouts.app')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-slate-900">Dashboard</h1>
    <p class="text-slate-600 mt-1">Welcome back, <span class="font-semibold">{{ auth()->user()->name }}</span>!</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <div class="card rounded-xl p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-slate-500">Level {{ $stats['level_info']['level'] }}</p>
                <p class="text-3xl font-bold text-slate-900">{{ $stats['points'] }}</p>
                <p class="text-sm text-slate-500">Total Points</p>
            </div>
            <div class="w-14 h-14 rounded-xl bg-slate-100 flex items-center justify-center">
                <svg class="w-7 h-7 text-amber-500" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z"/>
                </svg>
            </div>
        </div>
        <div class="mt-4">
            <div class="w-full bg-slate-100 rounded-full h-2.5">
                <div class="bg-primary-600 h-2.5 rounded-full" style="width: {{ $stats['level_info']['progress_percentage'] }}%"></div>
            </div>
            <p class="text-xs text-slate-500 mt-2">{{ $stats['level_info']['points_to_next'] }} pts to next level</p>
        </div>
    </div>

    <div class="card rounded-xl p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-slate-500">Current Streak</p>
                <p class="text-3xl font-bold text-slate-900">{{ $stats['streak']['current_streak'] }}</p>
                <p class="text-sm text-slate-500">days</p>
            </div>
            <div class="w-14 h-14 rounded-xl bg-orange-50 flex items-center justify-center">
                <span class="text-2xl">🔥</span>
            </div>
        </div>
        <p class="text-sm text-slate-500 mt-3">Longest: {{ $stats['streak']['longest_streak'] }} days</p>
    </div>

    <div class="card rounded-xl p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-slate-500">Badges Earned</p>
                <p class="text-3xl font-bold text-slate-900">{{ $stats['badges_count'] }}/{{ $stats['total_badges'] }}</p>
                <p class="text-sm text-slate-500">badges</p>
            </div>
            <div class="w-14 h-14 rounded-xl bg-amber-50 flex items-center justify-center">
                <svg class="w-7 h-7 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                </svg>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <div class="card rounded-xl p-6">
        <h2 class="text-lg font-semibold text-slate-900 mb-4">Your Progress</h2>
        <div class="space-y-4">
            <div class="flex items-center justify-between p-3 rounded-lg bg-slate-50">
                <span class="text-slate-600">Resources Completed</span>
                <span class="font-bold text-primary-600">{{ $stats['resources_completed'] }}</span>
            </div>
            <div class="flex items-center justify-between p-3 rounded-lg bg-slate-50">
                <span class="text-slate-600">Paths Completed</span>
                <span class="font-bold text-primary-600">{{ $stats['paths_completed'] }}</span>
            </div>
            <div class="flex items-center justify-between p-3 rounded-lg bg-slate-50">
                <span class="text-slate-600">Quizzes Passed</span>
                <span class="font-bold text-primary-600">{{ $stats['quizzes_passed'] }}</span>
            </div>
        </div>
    </div>

    <div class="card rounded-xl p-6">
        <h2 class="text-lg font-semibold text-slate-900 mb-4">Recent Badges</h2>
        @if($badges->count() > 0)
            <div class="flex flex-wrap gap-3">
                @foreach($badges->take(6) as $badge)
                    <div class="flex items-center gap-2 px-3 py-2 rounded-lg bg-amber-50 border border-amber-100" title="{{ $badge->description }}">
                        <span class="text-lg">{{ $badge->icon }}</span>
                        <span class="text-sm font-medium text-slate-700">{{ $badge->name }}</span>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-slate-500 text-sm">Complete resources and quizzes to earn badges!</p>
        @endif
        <a href="{{ route('badges') }}" class="text-primary-600 text-sm mt-4 inline-block hover:text-primary-700">View all badges →</a>
    </div>
</div>

@if($continuePaths->count() > 0)
<div class="card rounded-xl p-6 mb-8">
    <h2 class="text-lg font-semibold text-slate-900 mb-4">Continue Learning</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        @foreach($continuePaths as $pathProgress)
            <a href="{{ route('paths.show', $pathProgress->learningPath) }}" class="block p-4 border border-slate-200 rounded-lg hover:border-primary-300 hover:bg-slate-50 transition">
                <div class="flex items-center gap-3 mb-3">
                    <span class="text-2xl">{{ $pathProgress->learningPath->icon ?? '📚' }}</span>
                    <div>
                        <h3 class="font-medium text-slate-900">{{ $pathProgress->learningPath->title }}</h3>
                        <p class="text-sm text-slate-500">Step {{ $pathProgress->current_step }} of {{ $pathProgress->learningPath->steps->count() }}</p>
                    </div>
                </div>
                <div class="w-full bg-slate-100 rounded-full h-2">
                    <div class="bg-primary-600 h-2 rounded-full" style="width: {{ $pathProgress->getProgressPercentage($pathProgress->learningPath->steps->count()) }}%"></div>
                </div>
            </a>
        @endforeach
    </div>
</div>
@endif

@if($suggestedResources->count() > 0)
<div class="card rounded-xl p-6">
    <h2 class="text-lg font-semibold text-slate-900 mb-4">Suggested For You</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        @foreach($suggestedResources as $resource)
            <a href="{{ route('resources.show', $resource) }}" class="block p-4 border border-slate-200 rounded-lg hover:border-primary-300 hover:shadow-md transition">
                <div class="flex items-center gap-2 mb-2">
                    <span class="text-xl">{{ $resource->icon ?? '📄' }}</span>
                    <span class="text-xs px-2 py-1 bg-slate-100 rounded text-slate-600">{{ $resource->category }}</span>
                </div>
                <h3 class="font-medium text-slate-900 text-sm">{{ $resource->title }}</h3>
                <p class="text-xs text-slate-500 mt-1">{{ $resource->duration_minutes }} min · Level {{ $resource->difficulty_level }}</p>
            </a>
        @endforeach
    </div>
</div>
@endif
@endsection
