@extends('layouts.app')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-slate-900">Leaderboard</h1>
    <p class="text-slate-600 mt-1">Top learners in the community</p>
</div>

@if($userRank)
<div class="bg-primary-50 rounded-xl p-4 mb-6 text-center border border-primary-100">
    <p class="text-primary-600">Your rank: <span class="font-bold text-xl">#{{ $userRank }}</span></p>
</div>
@endif

<div class="card rounded-xl overflow-hidden">
    <table class="min-w-full">
        <thead class="bg-slate-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Rank</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">User</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Points</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Level</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-200">
            @foreach($topUsers as $index => $user)
                <tr class="{{ $user->id === auth()->id() ? 'bg-primary-50' : '' }}">
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($index < 3)
                            <span class="text-2xl">
                                @if($index === 0) 🥇
                                @elseif($index === 1) 🥈
                                @else 🥉
                                @endif
                            </span>
                        @else
                            <span class="text-slate-500 font-medium">#{{ $index + 1 }}</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="h-10 w-10 rounded-full bg-primary-600 flex items-center justify-center text-white font-medium">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                            <div class="ml-4">
                                <span class="font-medium text-slate-900">
                                    {{ $user->name }}
                                    @if($user->id === auth()->id())
                                        <span class="text-xs text-primary-600">(You)</span>
                                    @endif
                                </span>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="text-primary-600 font-semibold">{{ $user->points }} pts</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @php
                            $pointsService = app(\App\Services\PointsService::class);
                            $level = $pointsService->getUserLevel($user->points);
                        @endphp
                        <span class="px-2 py-1 bg-slate-100 rounded text-sm text-slate-600">Level {{ $level }}</span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
