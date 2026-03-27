<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Services\ProgressService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class QuizController extends Controller
{
    protected ProgressService $progressService;

    public function __construct(ProgressService $progressService)
    {
        $this->progressService = $progressService;
    }

    public function index(Request $request): View
    {
        $quizzes = Quiz::published()
            ->with('learningPath')
            ->withCount('questions')
            ->get();

        if ($request->user()) {
            $attemptData = [];
            foreach ($quizzes as $quiz) {
                $bestAttempt = $request->user()->quizAttempts()
                    ->where('quiz_id', $quiz->id)
                    ->orderBy('score', 'desc')
                    ->first();
                
                $attemptCount = $request->user()->quizAttempts()
                    ->where('quiz_id', $quiz->id)
                    ->count();
                
                $attemptData[$quiz->id] = [
                    'best_score' => $bestAttempt?->score,
                    'attempt_count' => $attemptCount,
                    'has_passed' => $bestAttempt?->passed ?? false,
                ];
            }
        } else {
            $attemptData = [];
        }

        return view('quizzes.index', compact('quizzes', 'attemptData'));
    }

    public function show(Request $request, Quiz $quiz): View
    {
        $randomize = $request->boolean('randomize', true);
        
        $query = $quiz->questions();
        
        if ($randomize) {
            $query->inRandomOrder();
        } else {
            $query->orderBy('order');
        }
        
        $quiz->setRelation('questions', $query->get());

        if ($request->user()) {
            $attemptCount = $request->user()->quizAttempts()
                ->where('quiz_id', $quiz->id)
                ->count();
            
            $bestAttempt = $request->user()->quizAttempts()
                ->where('quiz_id', $quiz->id)
                ->orderBy('score', 'desc')
                ->first();
                
            $lastAttempt = $request->user()->quizAttempts()
                ->where('quiz_id', $quiz->id)
                ->orderBy('created_at', 'desc')
                ->first();
        } else {
            $attemptCount = 0;
            $bestAttempt = null;
            $lastAttempt = null;
        }

        $canRetake = $quiz->max_attempts === 0 || $attemptCount < $quiz->max_attempts;

        return view('quizzes.show', compact(
            'quiz', 
            'attemptCount', 
            'bestAttempt',
            'canRetake',
            'lastAttempt',
            'randomize'
        ));
    }
    
    public function review(Request $request, Quiz $quiz): View
    {
        $attemptId = $request->get('attempt_id');
        
        $attempt = $request->user()->quizAttempts()
            ->where('quiz_id', $quiz->id)
            ->with('quiz.questions')
            ->find($attemptId);
            
        if (!$attempt) {
            $attempt = $request->user()->quizAttempts()
                ->where('quiz_id', $quiz->id)
                ->with('quiz.questions')
                ->orderBy('created_at', 'desc')
                ->first();
        }
        
        if (!$attempt) {
            return redirect()->route('quizzes.show', $quiz)
                ->with('error', 'No attempt found to review.');
        }
        
        $attempt->load('quiz.questions');
        
        $userAnswers = is_string($attempt->answers) ? json_decode($attempt->answers, true) : $attempt->answers;
        
        return view('quizzes.review', compact('quiz', 'attempt', 'userAnswers'));
    }

    public function submit(Request $request, Quiz $quiz): RedirectResponse
    {
        $request->validate([
            'answers' => 'required|array',
        ]);

        $attempt = $this->progressService->submitQuiz(
            $request->user(),
            $quiz,
            $request->answers
        );

        return redirect()->route('quizzes.result', $quiz)
            ->with('attempt_id', $attempt->id);
    }

    public function result(Request $request, Quiz $quiz): View
    {
        $attemptId = $request->session()->get('attempt_id');
        
        $attempt = $request->user()->quizAttempts()
            ->where('quiz_id', $quiz->id)
            ->find($attemptId);

        if (!$attempt) {
            $attempt = $request->user()->quizAttempts()
                ->where('quiz_id', $quiz->id)
                ->orderBy('created_at', 'desc')
                ->first();
        }

        $attemptCount = $request->user()->quizAttempts()
            ->where('quiz_id', $quiz->id)
            ->count();

        $canRetake = $quiz->max_attempts === 0 || $attemptCount < $quiz->max_attempts;

        return view('quizzes.result', compact('quiz', 'attempt', 'canRetake'));
    }

    public function retake(Request $request, Quiz $quiz): RedirectResponse
    {
        return redirect()->route('quizzes.show', $quiz);
    }
}
