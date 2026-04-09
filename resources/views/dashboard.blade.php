@extends('layouts.app')

@section('content')
<style>
    .progress-bar {
        background: var(--orange-600);
    }
</style>

<div class="app-header">
    <h1 class="app-title">
        <span>📊</span>
        Dashboard
    </h1>
    <p class="app-subtitle">Welcome back, {{ auth()->user()->name }}! Here's your learning progress.</p>
</div>

<div class="card-grid mb-8">
    <div class="stat-card">
        <div class="stat-header">
            <div>
                <div class="stat-label">Level {{ $stats['level_info']['level'] }}</div>
                <div class="stat-value">{{ $stats['points'] }}</div>
                <div class="stat-label" style="color: var(--slate-500); margin-top: 4px;">Total Points</div>
            </div>
            <div class="stat-icon">⭐</div>
        </div>
        <div style="width: 100%; background: var(--slate-200); border-radius: 8px; height: 6px; overflow: hidden;">
            <div style="background: var(--orange-600); height: 100%; width: {{ $stats['level_info']['progress_percentage'] }}%;"></div>
        </div>
        <p style="font-size: 12px; color: var(--slate-500); margin-top: 8px;">{{ $stats['level_info']['points_to_next'] }} pts to next level</p>
    </div>

    <div class="stat-card">
        <div class="stat-header">
            <div>
                <div class="stat-label">Current Streak</div>
                <div class="stat-value">{{ $stats['streak']['current_streak'] }}</div>
                <div class="stat-label" style="color: var(--slate-500); margin-top: 4px;">days</div>
            </div>
            <div class="stat-icon">🔥</div>
        </div>
        <p style="font-size: 12px; color: var(--slate-500);">Longest: {{ $stats['streak']['longest_streak'] }} days</p>
    </div>

    <div class="stat-card">
        <div class="stat-header">
            <div>
                <div class="stat-label">Badges Earned</div>
                <div class="stat-value">{{ $stats['badges_count'] }}/{{ $stats['total_badges'] }}</div>
                <div class="stat-label" style="color: var(--slate-500); margin-top: 4px;">badges</div>
            </div>
            <div class="stat-icon">🏆</div>
        </div>
    </div>
</div>
@endsection
