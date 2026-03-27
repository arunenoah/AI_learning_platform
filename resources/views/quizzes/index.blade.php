@extends('layouts.app')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-slate-900">Quizzes</h1>
    <p class="text-slate-600 mt-1">Test your knowledge and earn badges</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($quizzes as $quiz)
        <div class="card rounded-xl p-6">
            <h3 class="text-xl font-semibold text-slate-900 mb-2">{{ $quiz->title }}</h3>
            @if($quiz->learningPath)
                <span class="text-xs px-2 py-1 bg-blue-50 text-blue-600 rounded font-medium">{{ $quiz->learningPath->title }}</span>
            @endif
            <p class="text-slate-600 text-sm mt-3 mb-4">{{ $quiz->description }}</p>
            
            <div class="flex items-center text-sm text-slate-500 mb-4">
                <span class="flex items-center mr-4">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ $quiz->questions_count }} questions
                </span>
                <span class="flex items-center">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ $quiz->passing_score }}% to pass
                </span>
            </div>

            @if(isset($attemptData[$quiz->id]))
                <div class="bg-slate-50 p-3 rounded-lg mb-4 border border-slate-200">
                    @if($attemptData[$quiz->id]['has_passed'])
                        <div class="flex items-center text-green-600 text-sm font-medium">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Passed ({{ $attemptData[$quiz->id]['best_score'] }}%)
                        </div>
                    @else
                        <div class="flex items-center text-orange-600 text-sm font-medium">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                            Best: {{ $attemptData[$quiz->id]['best_score'] }}%
                        </div>
                    @endif
                    <p class="text-xs text-slate-500 mt-1">{{ $attemptData[$quiz->id]['attempt_count'] }} attempts</p>
                </div>
            @endif

            <a href="{{ route('quizzes.show', $quiz) }}" 
               class="btn-primary block w-full text-white text-center px-4 py-2.5 rounded-lg font-medium">
                {{ isset($attemptData[$quiz->id]) && $attemptData[$quiz->id]['has_passed'] ? 'Retake Quiz' : 'Start Quiz' }}
            </a>
        </div>
    @empty
        <div class="col-span-full text-center py-12">
            <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-slate-100 flex items-center justify-center">
                <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <p class="text-slate-500">No quizzes available yet.</p>
        </div>
    @endforelse
</div>
@endsection
