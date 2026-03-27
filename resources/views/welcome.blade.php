@extends('layouts.app')

@section('title', 'Welcome - Learning Platform')

@section('content')
<div class="min-h-[60vh] flex items-center justify-center">
    <div class="text-center">
        <h1 class="text-5xl font-bold text-slate-900 mb-6">
            Welcome to Your Learning Journey
        </h1>
        <p class="text-xl text-slate-600 mb-8 max-w-2xl mx-auto">
            Master web development with our curated resources, structured learning paths, and interactive quizzes.
        </p>
        <div class="flex gap-4 justify-center">
            @guest
                <a href="{{ route('register') }}" class="btn-primary text-white px-8 py-3 rounded-lg text-lg font-medium">
                    Get Started
                </a>
                <a href="{{ route('login') }}" class="bg-slate-200 text-slate-800 px-8 py-3 rounded-lg text-lg font-medium hover:bg-slate-300 transition">
                    Sign In
                </a>
            @else
                <a href="{{ route('dashboard') }}" class="btn-primary text-white px-8 py-3 rounded-lg text-lg font-medium">
                    Go to Dashboard
                </a>
                <a href="{{ route('paths.index') }}" class="bg-slate-200 text-slate-800 px-8 py-3 rounded-lg text-lg font-medium hover:bg-slate-300 transition">
                    Browse Paths
                </a>
            @endguest
        </div>
    </div>
</div>

<div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
    <div class="card p-6 rounded-xl text-center">
        <div class="text-4xl mb-4">📚</div>
        <h3 class="text-xl font-semibold text-slate-900 mb-2">Curated Resources</h3>
        <p class="text-slate-600">Access 70+ carefully selected learning resources across multiple technologies.</p>
    </div>
    <div class="card p-6 rounded-xl text-center">
        <div class="text-4xl mb-4">🛤️</div>
        <h3 class="text-xl font-semibold text-slate-900 mb-2">Learning Paths</h3>
        <p class="text-slate-600">Follow structured paths from beginner to advanced with step-by-step guidance.</p>
    </div>
    <div class="card p-6 rounded-xl text-center">
        <div class="text-4xl mb-4">🏆</div>
        <h3 class="text-xl font-semibold text-slate-900 mb-2">Earn Badges</h3>
        <p class="text-slate-600">Track your progress and earn badges as you complete learning milestones.</p>
    </div>
</div>
@endsection
