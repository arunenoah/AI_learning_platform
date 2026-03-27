@extends('layouts.app')

@section('content')
<div class="mb-6">
    <a href="{{ route('quizzes.show', $quiz) }}" class="text-primary-600 hover:text-primary-700 font-medium inline-flex items-center">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Back to Quiz
    </a>
</div>

<div class="card rounded-xl p-8">
    <div class="flex items-start justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 mb-2">{{ $quiz->title }}</h1>
            <p class="text-slate-500">Quiz Review</p>
        </div>
        <div class="text-right">
            <div class="text-sm text-slate-500 mb-2">
                {{ $attempt->created_at->format('M d, Y h:i A') }}
            </div>
            <span class="text-3xl font-bold {{ $attempt->passed ? 'text-green-600' : 'text-red-500' }}">
                {{ $attempt->score }}%
            </span>
            @if($attempt->passed)
                <span class="ml-2 bg-green-100 text-green-700 text-sm px-3 py-1 rounded-full font-medium">Passed</span>
            @else
                <span class="ml-2 bg-red-100 text-red-700 text-sm px-3 py-1 rounded-full font-medium">Failed</span>
            @endif
        </div>
    </div>

    <div class="bg-slate-50 rounded-xl p-6 mb-8 border border-slate-200">
        <div class="grid grid-cols-3 gap-6 text-center">
            <div>
                <div class="text-2xl font-bold text-green-600">{{ $attempt->correct_answers }}</div>
                <div class="text-sm text-slate-500">Correct</div>
            </div>
            <div>
                <div class="text-2xl font-bold text-red-500">{{ $attempt->total_questions - $attempt->correct_answers }}</div>
                <div class="text-sm text-slate-500">Incorrect</div>
            </div>
            <div>
                <div class="text-2xl font-bold text-slate-900">{{ $attempt->total_questions }}</div>
                <div class="text-sm text-slate-500">Total</div>
            </div>
        </div>
    </div>

    <div class="space-y-6">
        @foreach($attempt->quiz->questions as $index => $question)
            @php
                $userAnswer = $userAnswers[$question->id] ?? null;
                $isCorrect = $userAnswer == $question->correct_option;
            @endphp
            <div class="border rounded-xl p-6 {{ $isCorrect ? 'border-green-200 bg-green-50' : 'border-red-200 bg-red-50' }}">
                <div class="flex items-start gap-4">
                    <span class="flex-shrink-0 w-8 h-8 {{ $isCorrect ? 'bg-green-500 text-white' : 'bg-red-500 text-white' }} rounded-full flex items-center justify-center font-semibold text-sm">
                        @if($isCorrect)
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        @else
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        @endif
                    </span>
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="text-xs px-2 py-1 bg-white rounded text-slate-600 font-medium">Question {{ $index + 1 }}</span>
                            @if(!$isCorrect)
                                <span class="text-xs px-2 py-1 bg-red-100 rounded text-red-600">Your answer: {{ is_numeric($userAnswer) ? chr(65 + $userAnswer) : 'Not answered' }}</span>
                                <span class="text-xs px-2 py-1 bg-green-100 rounded text-green-600">Correct: {{ chr(65 + $question->correct_option) }}</span>
                            @endif
                        </div>
                        <h3 class="font-semibold text-slate-900 mb-4">
                            {{ $question->question }}
                        </h3>
                        <div class="space-y-2">
                            @foreach($question->options as $optionIndex => $option)
                                @php
                                    $isSelected = $userAnswer == $optionIndex;
                                    $isCorrectOption = $optionIndex == $question->correct_option;
                                @endphp
                                <div class="p-4 rounded-lg border {{ $isCorrectOption ? 'border-green-500 bg-green-100' : ($isSelected && !$isCorrect ? 'border-red-500 bg-red-100' : 'border-slate-200 bg-white') }}">
                                    <div class="flex items-center">
                                        <span class="flex-shrink-0 w-6 h-6 {{ $isCorrectOption ? 'bg-green-500 text-white' : ($isSelected ? 'bg-red-500 text-white' : 'bg-slate-200 text-slate-600') }} rounded-full flex items-center justify-center text-sm mr-3">
                                            {{ chr(65 + $optionIndex) }}
                                        </span>
                                        <span class="{{ $isCorrectOption ? 'font-semibold text-green-800' : ($isSelected && !$isCorrect ? 'font-semibold text-red-800' : 'text-slate-700') }}">
                                            {{ $option }}
                                        </span>
                                        @if($isCorrectOption)
                                            <svg class="w-5 h-5 text-green-600 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                        @elseif($isSelected && !$isCorrect)
                                            <svg class="w-5 h-5 text-red-600 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @if($question->explanation)
                            <div class="mt-4 p-4 bg-white border border-slate-200 rounded-lg">
                                <div class="flex items-start gap-2">
                                    <svg class="w-5 h-5 text-blue-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <div>
                                        <span class="text-sm font-medium text-slate-700">Explanation:</span>
                                        <p class="text-sm text-slate-600 mt-1">{{ $question->explanation }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-8 flex items-center justify-between pt-6 border-t border-slate-200">
        <a href="{{ route('quizzes.show', $quiz) }}" 
           class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-6 py-3 rounded-lg font-medium">
            Retake Quiz
        </a>
        <a href="{{ route('quizzes.index') }}" 
           class="btn-primary text-white px-6 py-3 rounded-lg font-medium">
            Back to Quizzes
        </a>
    </div>
</div>
@endsection
