@extends('layouts.app')

@section('content')
<div class="mb-6">
    <a href="{{ route('paths.index') }}" class="inline-flex items-center text-primary-600 hover:text-primary-700 font-medium">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Back to Paths
    </a>
</div>

<div class="card rounded-xl p-8 mb-8">
    <div class="flex items-start justify-between mb-6">
        <div>
            <span class="text-5xl mb-4 block">{{ $path->icon ?? '📚' }}</span>
            <span class="text-xs px-2.5 py-1 bg-slate-100 rounded-full text-slate-600 capitalize font-medium">{{ $path->difficulty }}</span>
        </div>
        @if($progress && $progress->is_completed)
            <span class="bg-green-100 text-green-700 text-sm px-4 py-1.5 rounded-full font-medium flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Completed
            </span>
        @elseif($progress && $progress->is_started)
            <span class="bg-blue-100 text-blue-700 text-sm px-4 py-1.5 rounded-full font-medium">In Progress</span>
        @endif
    </div>

    <h1 class="text-3xl font-bold text-slate-900 mb-4">{{ $path->title }}</h1>
    <p class="text-slate-600 mb-6">{{ $path->description }}</p>

    <div class="flex items-center text-sm text-slate-500 mb-6">
        <span class="flex items-center mr-6">
            <svg class="w-4 h-4 mr-1.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            {{ $totalSteps }} steps
        </span>
        <span class="flex items-center">
            <svg class="w-4 h-4 mr-1.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ $path->estimated_hours }} hours
        </span>
    </div>

    <div class="mb-6">
        <div class="flex justify-between text-sm mb-2">
            <span class="font-medium text-slate-700">Progress</span>
            <span class="font-bold text-primary-600">{{ $percentage }}%</span>
        </div>
        <div class="w-full bg-slate-100 rounded-full h-2.5">
            <div class="bg-primary-600 h-2.5 rounded-full" style="width: {{ $percentage }}%"></div>
        </div>
    </div>

    @auth
        @if(!$progress || !$progress->is_started)
            <form action="{{ route('paths.start', $path) }}" method="POST" class="inline-block">
                @csrf
                <button type="submit" class="btn-primary text-white px-6 py-3 rounded-lg font-medium">
                    Start Learning Path (+10 points)
                </button>
            </form>
        @endif
    @endauth
</div>

<h2 class="text-xl font-bold text-slate-900 mb-4">Learning Steps</h2>
<div class="space-y-4">
    @foreach($path->steps as $index => $step)
        @php
            $isCompleted = in_array($step->resource_id, $completedResourceIds ?? []);
            $isAccessible = $index === 0 || in_array($path->steps[$index - 1]->resource_id, $completedResourceIds ?? []);
        @endphp
        <div class="card rounded-xl p-6 {{ $isCompleted ? 'border-green-200 bg-green-50/30' : ($isAccessible ? '' : 'opacity-60') }}">
            <div class="flex items-center">
                <div class="flex-shrink-0 w-10 h-10 rounded-full {{ $isCompleted ? 'bg-green-500 text-white' : 'bg-slate-100 text-slate-600' }} flex items-center justify-center mr-4 font-semibold">
                    @if($isCompleted)
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    @else
                        {{ $index + 1 }}
                    @endif
                </div>
                <div class="flex-1">
                    <h3 class="font-semibold text-slate-900">{{ $step->title ?? $step->resource->title }}</h3>
                    <p class="text-sm text-slate-600 mt-1">{{ $step->resource->description }}</p>
                    <div class="flex items-center text-xs text-slate-500 mt-2">
                        <span class="mr-3 px-2 py-0.5 bg-slate-100 rounded">{{ $step->resource->category }}</span>
                        <span>{{ $step->resource->duration_minutes }} min</span>
                        @if($isCompleted)
                            <span class="ml-3 text-green-600 font-medium">Completed</span>
                        @endif
                    </div>
                </div>
                <div class="flex-shrink-0 ml-4">
                    @if($isAccessible)
                        <a href="{{ route('resources.show', $step->resource) }}" 
                           class="btn-primary text-white px-4 py-2 rounded-lg text-sm font-medium inline-block">
                            {{ $isCompleted ? 'Review' : 'Start' }}
                        </a>
                    @else
                        <span class="text-slate-400 text-sm">Complete previous step</span>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
