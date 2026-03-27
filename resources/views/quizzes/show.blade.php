@extends('layouts.app')

@section('content')
<div class="mb-6">
    <a href="{{ route('quizzes.index') }}" class="text-primary-600 hover:text-primary-700 font-medium inline-flex items-center">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Back to Quizzes
    </a>
</div>

<div class="card rounded-xl p-8">
    <div class="flex items-start justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 mb-2">{{ $quiz->title }}</h1>
            @if($quiz->learningPath)
                <span class="text-xs px-2.5 py-1 bg-blue-50 text-blue-600 rounded-full font-medium">{{ $quiz->learningPath->title }}</span>
            @endif
            <p class="text-slate-600 mt-3">{{ $quiz->description }}</p>
        </div>
        
        @if($lastAttempt)
            <a href="{{ route('quizzes.review', [$quiz, 'attempt_id' => $lastAttempt->id]) }}" 
               class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2 rounded-lg text-sm font-medium flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
                Review Last Attempt
            </a>
        @endif
    </div>

    <div class="flex items-center text-sm text-slate-500 mb-6">
        <span class="mr-4">{{ $quiz->questions->count() }} questions</span>
        <span class="mr-4">{{ $quiz->passing_score }}% to pass</span>
        @if($quiz->max_attempts > 0)
            <span>{{ $attemptCount }} / {{ $quiz->max_attempts }} attempts</span>
        @else
            <span>Unlimited attempts</span>
        @endif
    </div>

    @if($bestAttempt)
        <div class="bg-slate-50 p-6 rounded-xl mb-6 border border-slate-200">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="font-semibold text-slate-900 mb-1">Your Best Score</h3>
                    <p class="text-sm text-slate-500">
                        {{ $bestAttempt->correct_answers }} / {{ $bestAttempt->total_questions }} correct
                    </p>
                </div>
                <div class="text-right">
                    <span class="text-4xl font-bold {{ $bestAttempt->passed ? 'text-green-600' : 'text-orange-500' }}">
                        {{ $bestAttempt->score }}%
                    </span>
                    @if($bestAttempt->passed)
                        <span class="ml-3 bg-green-100 text-green-700 text-sm px-3 py-1 rounded-full font-medium">Passed</span>
                    @endif
                </div>
            </div>
        </div>
    @endif

    <div class="bg-blue-50 border border-blue-100 rounded-xl p-6 mb-8">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-2">
                    <input type="checkbox" id="randomize" name="randomize" value="1" {{ $randomize ? 'checked' : '' }}
                           class="w-4 h-4 text-primary-600 rounded focus:ring-primary-500">
                    <label for="randomize" class="text-sm font-medium text-slate-700">
                        Randomize question order
                    </label>
                </div>
            </div>
            <a href="{{ route('quizzes.show', [$quiz, 'randomize' => !$randomize]) }}" 
               class="text-primary-600 hover:text-primary-700 text-sm font-medium">
                {{ $randomize ? 'Show in order' : 'Shuffle questions' }}
            </a>
        </div>
    </div>

    @if($canRetake || !$bestAttempt)
        <form action="{{ route('quizzes.submit', $quiz) }}" method="POST" id="quiz-form">
            @csrf
            <input type="hidden" name="randomize" value="{{ $randomize ? '1' : '0' }}">
            
            <div class="space-y-6" id="questions-container">
                @foreach($quiz->questions as $index => $question)
                    <div class="border border-slate-200 rounded-xl p-6 hover:border-primary-200 transition" id="question-{{ $question->id }}">
                        <div class="flex items-start gap-4">
                            <span class="flex-shrink-0 w-8 h-8 bg-primary-100 text-primary-700 rounded-full flex items-center justify-center font-semibold text-sm">
                                {{ $index + 1 }}
                            </span>
                            <div class="flex-1">
                                <h3 class="font-semibold text-slate-900 mb-4">
                                    {{ $question->question }}
                                </h3>
                                <div class="space-y-2">
                                    @foreach($question->options as $optionIndex => $option)
                                        <label class="flex items-center p-4 border border-slate-200 rounded-lg cursor-pointer hover:bg-primary-50 hover:border-primary-200 transition">
                                            <input type="radio" 
                                                   name="answers[{{ $question->id }}]" 
                                                   value="{{ $optionIndex }}"
                                                   class="w-4 h-4 text-primary-600 focus:ring-primary-500"
                                                   required>
                                            <span class="ml-3 text-slate-700">{{ $option }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8 flex items-center justify-between pt-6 border-t border-slate-200">
                <div class="flex items-center gap-4">
                    <span class="text-sm text-slate-500">
                        <span id="answered-count">0</span> / {{ $quiz->questions->count() }} answered
                    </span>
                    <div class="w-32 bg-slate-200 rounded-full h-2">
                        <div id="progress-bar" class="bg-primary-600 h-2 rounded-full transition-all" style="width: 0%"></div>
                    </div>
                </div>
                <button type="submit" class="btn-primary text-white px-8 py-3 rounded-lg font-medium flex items-center gap-2">
                    <span>Submit Quiz</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </button>
            </div>
        </form>
    @else
        <div class="bg-amber-50 border border-amber-200 rounded-lg p-6 text-center">
            <p class="text-amber-800">You've reached the maximum number of attempts for this quiz.</p>
        </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('quiz-form');
    const answeredCount = document.getElementById('answered-count');
    const progressBar = document.getElementById('progress-bar');
    const totalQuestions = {{ $quiz->questions->count() }};
    
    function updateProgress() {
        const answered = form.querySelectorAll('input[type="radio"]:checked').length;
        answeredCount.textContent = answered;
        progressBar.style.width = ((answered / totalQuestions) * 100) + '%';
    }
    
    form.addEventListener('change', updateProgress);
    updateProgress();
    
    form.addEventListener('submit', function(e) {
        const answered = form.querySelectorAll('input[type="radio"]:checked').length;
        if (answered < totalQuestions) {
            e.preventDefault();
            alert('Please answer all questions before submitting.');
        }
    });
});
</script>
@endsection
