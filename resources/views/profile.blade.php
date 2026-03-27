@extends('layouts.app')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">Your Profile</h1>
    <p class="text-gray-600 mt-1">Track your learning journey</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
            <div class="flex items-center mb-6">
                <div class="h-20 w-20 rounded-full bg-indigo-600 flex items-center justify-center text-white text-2xl font-bold">
                    {{ substr($user->name, 0, 1) }}
                </div>
                <div class="ml-4">
                    <h2 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h2>
                    <p class="text-gray-600">{{ $user->email }}</p>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-4">
                <div class="text-center p-4 bg-indigo-50 rounded-lg">
                    <p class="text-3xl font-bold text-indigo-600">{{ $stats['points'] }}</p>
                    <p class="text-sm text-gray-600">Total Points</p>
                    <p class="text-xs text-indigo-500">Level {{ $stats['level_info']['level'] }}</p>
                </div>
                <div class="text-center p-4 bg-orange-50 rounded-lg">
                    <p class="text-3xl font-bold text-orange-500">{{ $stats['streak']['current_streak'] }}</p>
                    <p class="text-sm text-gray-600">Day Streak</p>
                </div>
                <div class="text-center p-4 bg-yellow-50 rounded-lg">
                    <p class="text-3xl font-bold text-yellow-500">{{ $stats['badges_count'] }}</p>
                    <p class="text-sm text-gray-600">Badges</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Progress Stats</h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <span class="text-gray-600">Resources Completed</span>
                    <span class="font-semibold text-indigo-600">{{ $stats['resources_completed'] }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-600">Paths Completed</span>
                    <span class="font-semibold text-indigo-600">{{ $stats['paths_completed'] }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-600">Quizzes Passed</span>
                    <span class="font-semibold text-indigo-600">{{ $stats['quizzes_passed'] }}</span>
                </div>
            </div>
        </div>

        @if($recentActivity->count() > 0)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Activity</h3>
            <div class="space-y-3">
                @foreach($recentActivity as $activity)
                    <div class="flex items-center justify-between py-2 border-b border-gray-100 last:border-0">
                        <div class="flex items-center">
                            <span class="text-xl mr-3">{{ $activity->resource->icon ?? '📄' }}</span>
                            <span class="text-gray-900">{{ $activity->resource->title }}</span>
                        </div>
                        <span class="text-sm text-gray-500">{{ $activity->completed_at->diffForHumans() }}</span>
                    </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    <div class="lg:col-span-1">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Badges Earned</h3>
            @if($badges->count() > 0)
                <div class="grid grid-cols-2 gap-3">
                    @foreach($badges as $badge)
                        <div class="text-center p-3 bg-yellow-50 rounded-lg" title="{{ $badge->description }}">
                            <span class="text-3xl">{{ $badge->icon }}</span>
                            <p class="text-xs font-medium text-yellow-800 mt-1">{{ $badge->name }}</p>
                        </div>
                    @endforeach
                </div>
                <a href="{{ route('badges') }}" class="text-indigo-600 text-sm mt-4 inline-block hover:underline">
                    View all badges →
                </a>
            @else
                <p class="text-gray-500 text-sm">Complete activities to earn badges!</p>
            @endif
        </div>

        @if($pathProgress->count() > 0)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Learning Paths</h3>
            <div class="space-y-4">
                @foreach($pathProgress as $progress)
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-sm font-medium text-gray-900">{{ $progress->learningPath->title }}</span>
                            <span class="text-xs text-gray-500">{{ $progress->getProgressPercentage($progress->learningPath->steps->count()) }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-indigo-600 h-2 rounded-full" style="width: {{ $progress->getProgressPercentage($progress->learningPath->steps->count()) }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
