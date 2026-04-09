<?php

use App\Http\Controllers\ClaudeCodeMaterialsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LearningPathController;
use App\Http\Controllers\ProgressController;
use App\Http\Controllers\QuestController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\ResourceController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('blogs.index'))->name('home');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/blogs', [ResourceController::class, 'index'])->name('blogs.index');
Route::get('/claude-code-materials', [ClaudeCodeMaterialsController::class, 'index'])->name('claude-code-materials.index');

Route::middleware('auth')->group(function () {
    Route::get('/resources', [ClaudeCodeMaterialsController::class, 'index'])->name('resources.index');
    Route::get('/resources/{resource}', [ResourceController::class, 'show'])->name('resources.show');
    Route::post('/resources/{resource}/complete', [ResourceController::class, 'complete'])->name('resources.complete');

    Route::get('/paths', [LearningPathController::class, 'index'])->name('paths.index');
    Route::get('/paths/{path}', [LearningPathController::class, 'show'])->name('paths.show');
    Route::post('/paths/{path}/start', [LearningPathController::class, 'start'])->name('paths.start');
    Route::post('/paths/{path}/step/{step}', [LearningPathController::class, 'completeStep'])->name('paths.step.complete');

    Route::get('/quizzes', [QuizController::class, 'index'])->name('quizzes.index');
    Route::get('/quizzes/{quiz}', [QuizController::class, 'show'])->name('quizzes.show');
    Route::post('/quizzes/{quiz}', [QuizController::class, 'submit'])->name('quizzes.submit');
    Route::get('/quizzes/{quiz}/result', [QuizController::class, 'result'])->name('quizzes.result');
    Route::post('/quizzes/{quiz}/retake', [QuizController::class, 'retake'])->name('quizzes.retake');
    Route::get('/quizzes/{quiz}/review', [QuizController::class, 'review'])->name('quizzes.review');

    Route::get('/profile', [ProgressController::class, 'profile'])->name('profile');
    Route::get('/leaderboard', [ProgressController::class, 'leaderboard'])->name('leaderboard');
    Route::get('/badges', [ProgressController::class, 'badges'])->name('badges');
    Route::get('/stats', [ProgressController::class, 'stats'])->name('stats');

    Route::post('/quests/{quest}/complete', [QuestController::class, 'complete'])->name('quests.complete');
});

require __DIR__.'/auth.php';
