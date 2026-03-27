@extends('layouts.app')

@section('content')
<div class="mb-6">
    <a href="{{ route('resources.index') }}" class="text-primary-600 hover:text-primary-700 font-medium inline-flex items-center">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Back to Resources
    </a>
</div>

<div class="card rounded-xl p-8">
    <div class="flex items-start justify-between mb-6">
        <div>
            <span class="text-5xl mb-4 block">{{ $resource->icon ?? '📄' }}</span>
            <span class="text-xs px-2.5 py-1 bg-slate-100 rounded-full text-slate-600 font-medium">{{ $resource->category }}</span>
        </div>
        @if($isCompleted)
            <span class="bg-green-100 text-green-700 text-sm px-4 py-1.5 rounded-full font-medium flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Completed
            </span>
        @endif
    </div>

    <h1 class="text-3xl font-bold text-slate-900 mb-4">{{ $resource->title }}</h1>
    <p class="text-slate-600 mb-6">{{ $resource->description }}</p>

    <div class="flex flex-wrap gap-6 text-sm text-slate-500 mb-8">
        <span class="flex items-center">
            <svg class="w-4 h-4 mr-1.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ $resource->duration_minutes }} minutes
        </span>
        <span class="flex items-center">
            <svg class="w-4 h-4 mr-1.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5"/>
            </svg>
            Level {{ $resource->difficulty_level }}
        </span>
        <span class="flex items-center capitalize">
            <svg class="w-4 h-4 mr-1.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
            </svg>
            {{ $resource->type }}
        </span>
    </div>

    @if($resource->learning_reason)
        <div class="bg-primary-50 border border-primary-100 rounded-xl p-5 mb-8">
            <div class="flex gap-3">
                <svg class="w-5 h-5 text-primary-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                    <h3 class="text-sm font-semibold text-primary-800 mb-1">Why learn this</h3>
                    <p class="text-sm text-slate-700 leading-relaxed">{{ $resource->learning_reason }}</p>
                </div>
            </div>
        </div>
    @endif

    @if($resource->content)
        <div class="prose max-w-none mb-8">
            {!! nl2br(e($resource->content)) !!}
        </div>
    @endif

    @if($resource->url)
        <div class="mb-8">
            <a href="{{ $resource->url }}" target="_blank" 
               class="inline-flex items-center btn-primary text-white px-6 py-3 rounded-lg font-medium">
                <span>Open Resource</span>
                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                </svg>
            </a>
        </div>
    @endif

    @auth
        <div class="border-t pt-6">
            @if(!$isCompleted)
                <form action="{{ route('resources.complete', $resource) }}" method="POST" id="complete-form">
                    @csrf
                    <button type="submit" class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 flex items-center font-medium">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Mark as Complete (+25 points)
                    </button>
                </form>
            @else
                <p class="text-green-600 font-medium flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    You've completed this resource!
                </p>
            @endif
        </div>
    @endauth

    @guest
        <div class="border-t pt-6">
            <div class="bg-primary-50 border border-primary-200 rounded-xl p-6 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-slate-900 mb-1">Track your progress</h3>
                    <p class="text-sm text-slate-600">Sign up to mark resources as complete, earn points, and track your learning journey.</p>
                </div>
                <div class="flex items-center gap-3 flex-shrink-0 ml-6">
                    <a href="{{ route('login') }}" class="px-4 py-2.5 text-sm font-medium text-slate-600 hover:text-slate-900 transition-colors">Log in</a>
                    <a href="{{ route('register') }}" class="btn-primary px-5 py-2.5 rounded-lg text-sm font-semibold text-white">Sign up free</a>
                </div>
            </div>
        </div>
    @endguest
</div>
@endsection
