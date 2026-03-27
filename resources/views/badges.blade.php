@extends('layouts.app')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-slate-900">Badges</h1>
    <p class="text-slate-600 mt-1">Collect badges as you learn</p>
</div>

<div class="mb-8">
    <h2 class="text-lg font-semibold text-slate-900 mb-4">Earned Badges ({{ $earnedBadges->count() }})</h2>
    @if($earnedBadges->count() > 0)
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mb-8">
            @foreach($earnedBadges as $badge)
                <div class="card rounded-xl p-6 text-center bg-amber-50/50 border-amber-200">
                    <span class="text-5xl block mb-3">{{ $badge->icon }}</span>
                    <h3 class="font-semibold text-slate-900">{{ $badge->name }}</h3>
                    <p class="text-sm text-slate-600 mt-1">{{ $badge->description }}</p>
                    <p class="text-xs text-slate-500 mt-2">Earned {{ $badge->pivot->earned_at->diffForHumans() }}</p>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-slate-500 mb-8">You haven't earned any badges yet. Keep learning!</p>
    @endif
</div>

<div>
    <h2 class="text-lg font-semibold text-slate-900 mb-4">Badges to Earn ({{ $badgesWithProgress->count() }})</h2>
    @if($badgesWithProgress->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($badgesWithProgress as $item)
                @php $badge = $item['badge']; $progress = $item['progress']; @endphp
                <div class="card rounded-xl p-6">
                    <div class="flex items-start">
                        <span class="text-4xl opacity-50">{{ $badge->icon }}</span>
                        <div class="ml-4 flex-1">
                            <h3 class="font-semibold text-slate-700">{{ $badge->name }}</h3>
                            <p class="text-sm text-slate-500 mt-1">{{ $badge->description }}</p>
                            <div class="mt-3">
                                <div class="flex justify-between text-xs text-slate-500 mb-1">
                                    <span>Progress</span>
                                    <span>{{ $progress['current'] }} / {{ $progress['required'] }}</span>
                                </div>
                                <div class="w-full bg-slate-200 rounded-full h-2">
                                    <div class="bg-primary-600 h-2 rounded-full" style="width: {{ $progress['percentage'] }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="card rounded-xl p-8 text-center">
            <p class="text-slate-500">You've earned all available badges!</p>
        </div>
    @endif
</div>
@endsection
