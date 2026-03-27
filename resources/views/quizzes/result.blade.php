@extends('layouts.app')

@section('content')
<div class="card rounded-xl p-8">
    <h1 class="text-2xl font-bold text-slate-900 mb-2">{{ $quiz->title }} - Results</h1>
    
    <div class="mb-8">
        @if($attempt)
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-primary-50 rounded-xl p-6 text-center border border-primary-100">
                    <p class="text-5xl font-bold text-primary-600">{{ $attempt->score }}%</p>
                    <p class="text-sm text-slate-600 mt-2">Your Score</p>
                </div>
                <div class="bg-green-50 rounded-xl p-6 text-center border border-green-100">
                    <p class="text-5xl font-bold text-green-600">{{ $attempt->correct_answers }}</p>
                    <p class="text-sm text-slate-600 mt-2">Correct Answers</p>
                </div>
                <div class="bg-slate-50 rounded-xl p-6 text-center border border-slate-200">
                    <p class="text-5xl font-bold text-slate-600">{{ $attempt->total_questions }}</p>
                    <p class="text-sm text-slate-600 mt-2">Total Questions</p>
                </div>
            </div>

            <div class="mb-8 p-6 rounded-xl {{ $attempt->passed ? 'bg-green-50 border border-green-200' : 'bg-red-50 border border-red-200' }}">
                @if($attempt->passed)
                    <div class="flex items-center text-green-700">
                        <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-xl font-semibold">Congratulations! You passed!</span>
                    </div>
                    <p class="text-green-600 mt-2">You earned points for passing this quiz.</p>
                @else
                    <div class="flex items-center text-red-700">
                        <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-xl font-semibold">Not quite there yet!</span>
                    </div>
                    <p class="text-red-600 mt-2">You needed {{ $quiz->passing_score }}% to pass. Keep practicing!</p>
                @endif
            </div>

            <h2 class="text-lg font-semibold text-slate-900 mb-4">Question Review</h2>
            <div class="space-y-4">
                @foreach($attempt->quiz->questions as $index => $question)
                    @php
                        $userAnswer = $attempt->answers[$question->id] ?? null;
                        $isCorrect = $userAnswer === $question->correct_option;
                    @endphp
                    <div class="border rounded-lg p-4 {{ $isCorrect ? 'border-green-200 bg-green-50' : 'border-red-200 bg-red-50' }}">
                        <div class="flex items-start">
                            <span class="flex-shrink-0 mr-3">
                                @if($isCorrect)
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                @else
                                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                @endif
                            </span>
                            <div class="flex-1">
                                <p class="font-medium text-slate-900">Q{{ $index + 1 }}. {{ $question->question }}</p>
                                @if(!$isCorrect)
                                    <p class="text-sm text-red-600 mt-1">
                                        Your answer: {{ $question->options[$userAnswer] ?? 'Not answered' }}
                                    </p>
                                    <p class="text-sm text-green-600 mt-1">
                                        Correct answer: {{ $question->options[$question->correct_option] }}
                                    </p>
                                @endif
                                @if($question->explanation)
                                    <p class="text-sm text-slate-600 mt-2 italic">{{ $question->explanation }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8 flex gap-4">
                <a href="{{ route('quizzes.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-6 py-3 rounded-lg font-medium">
                    Back to Quizzes
                </a>
                @if($canRetake)
                    <form action="{{ route('quizzes.retake', $quiz) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-primary text-white px-6 py-3 rounded-lg font-medium">
                            Retake Quiz
                        </button>
                    </form>
                @endif
            </div>
        @else
            <p class="text-slate-600">No quiz attempt found.</p>
            <a href="{{ route('quizzes.show', $quiz) }}" class="text-primary-600 hover:underline mt-4 inline-block">
                Take the quiz
            </a>
        @endif
    </div>
</div>
@endsection
