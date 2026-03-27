@extends('layouts.app')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-slate-900">Learning Paths</h1>
    <p class="text-slate-600 mt-1">Follow structured paths to master new skills</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    @forelse($paths as $path)
        <a href="{{ route('paths.show', $path) }}" 
           class="card rounded-xl p-6 hover:border-primary-300 hover:shadow-lg transition">
            <div class="flex items-start justify-between mb-4">
                <span class="text-4xl">{{ $path->icon ?? '📚' }}</span>
                @if(isset($progressData[$path->id]))
                    @if($progressData[$path->id]['is_completed'])
                        <span class="bg-green-100 text-green-700 text-xs px-3 py-1 rounded-full font-medium">Completed</span>
                    @elseif($progressData[$path->id]['is_started'])
                        <span class="bg-blue-100 text-blue-700 text-xs px-3 py-1 rounded-full font-medium">In Progress</span>
                    @endif
                @endif
            </div>
            <h3 class="text-xl font-semibold text-slate-900 mb-2">{{ $path->title }}</h3>
            <p class="text-slate-600 text-sm mb-4">{{ $path->description }}</p>
            
            <div class="flex items-center text-sm text-slate-500 mb-4">
                <span class="flex items-center mr-4">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    {{ $path->steps_count }} steps
                </span>
                <span class="flex items-center mr-4">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ $path->estimated_hours }} hours
                </span>
                <span class="px-2 py-0.5 bg-slate-100 rounded text-xs capitalize">
                    {{ $path->difficulty }}
                </span>
            </div>

            @if(isset($progressData[$path->id]) && $progressData[$path->id]['is_started'])
                <div class="w-full bg-slate-100 rounded-full h-2">
                    <div class="bg-primary-600 h-2 rounded-full" style="width: {{ $progressData[$path->id]['percentage'] }}%"></div>
                </div>
                <p class="text-xs text-slate-500 mt-2">
                    {{ $progressData[$path->id]['current_step'] }} of {{ $path->steps_count }} steps completed
                </p>
            @else
                <div class="w-full bg-slate-100 rounded-full h-2">
                    <div class="bg-slate-200 h-2 rounded-full" style="width: 0%"></div>
                </div>
                <p class="text-xs text-slate-500 mt-2">Not started yet</p>
            @endif
        </a>
    @empty
        <div class="col-span-full text-center py-12">
            <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-slate-100 flex items-center justify-center">
                <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
            <p class="text-slate-500">No learning paths available yet.</p>
        </div>
    @endforelse
</div>
@endsection
