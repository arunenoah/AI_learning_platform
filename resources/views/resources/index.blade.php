@extends('layouts.app')

@section('content')
<style>
    .resource-popup {
        position: fixed;
        width: 340px;
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.12), 0 0 0 1px rgba(0,0,0,0.05);
        opacity: 0;
        pointer-events: none;
        transform: translateY(6px);
        transition: opacity 0.18s ease, transform 0.18s ease;
        z-index: 100;
        overflow: hidden;
    }
    .resource-popup.popup-visible {
        opacity: 1;
        pointer-events: auto;
        transform: translateY(0);
    }
    .popup-header {
        padding: 16px 20px 12px;
        border-bottom: 1px solid #f1f5f9;
    }
    .popup-body {
        padding: 12px 20px;
    }
    .popup-footer {
        padding: 12px 20px 16px;
        border-top: 1px solid #f1f5f9;
    }
    @media (hover: none) {
        .resource-popup { display: none !important; }
    }
</style>
<div class="mb-8">
    <h1 class="text-3xl font-bold text-slate-900">Learning Resources</h1>
    <p class="text-slate-600 mt-1">Browse all available learning materials</p>
</div>

<form method="GET" class="mb-6 card p-4">
    <div class="flex flex-wrap gap-4">
        <div class="flex-1 min-w-[200px]">
            <input type="text" name="search" placeholder="Search resources..." 
                   value="{{ request('search') }}"
                   class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
        </div>
        <div class="w-48">
            <select name="category" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                <option value="all">All Categories</option>
                @foreach($categories as $category)
                    <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                        {{ $category }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="w-40">
            <select name="difficulty" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                <option value="">All Levels</option>
                <option value="1" {{ request('difficulty') == '1' ? 'selected' : '' }}>Beginner</option>
                <option value="2" {{ request('difficulty') == '2' ? 'selected' : '' }}>Intermediate</option>
                <option value="3" {{ request('difficulty') == '3' ? 'selected' : '' }}>Advanced</option>
            </select>
        </div>
        <button type="submit" class="btn-primary text-white px-6 py-2 rounded-lg">
            Filter
        </button>
    </div>
</form>

<div class="flex gap-6">
    <div class="w-full">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="resourcesGrid">
            @forelse($resources as $resource)
                <div data-resource-id="{{ $resource->id }}" 
                     onclick="showResourcePane({{ $resource->id }})"
                     class="card rounded-xl p-6 hover:border-primary-300 hover:shadow-md transition cursor-pointer resource-card"
                     data-url="{{ $resource->url }}"
                     data-title="{{ $resource->title }}"
                     data-description="{{ $resource->description }}"
                     data-type="{{ $resource->type }}"
                     data-duration="{{ $resource->duration_minutes }}"
                     data-category="{{ $resource->category }}"
                     data-difficulty="{{ $resource->difficulty_level }}"
                     data-learning-reason="{{ e($resource->learning_reason) }}">
                    <div class="flex items-start justify-between mb-4">
                        <span class="text-3xl">{{ $resource->icon ?? '📄' }}</span>
                        @if(in_array($resource->id, $completedIds ?? []))
                            <span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full font-medium">Completed</span>
                        @endif
                    </div>
                    <span class="text-xs px-2 py-1 bg-slate-100 rounded text-slate-600">{{ $resource->category }}</span>
                    <h3 class="text-lg font-semibold text-slate-900 mt-2 mb-2">{{ $resource->title }}</h3>
                    <p class="text-sm text-slate-600 line-clamp-2 mb-4">{{ $resource->description }}</p>
                    <div class="flex items-center text-xs text-slate-500">
                        <span>{{ $resource->duration_minutes }} min</span>
                        <span class="mx-2">·</span>
                        <span>Level {{ $resource->difficulty_level }}</span>
                        <span class="mx-2">·</span>
                        <span class="capitalize">{{ $resource->type }}</span>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-slate-100 flex items-center justify-center">
                        <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <p class="text-slate-500">No resources found matching your criteria.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $resources->withQueryString()->links() }}
        </div>
    </div>
</div>

<div id="resourcePane" class="fixed inset-y-0 right-0 w-full md:w-[600px] bg-white shadow-2xl transform translate-x-full transition-transform duration-300 z-50 overflow-hidden flex flex-col border-l border-slate-200">
    <div class="bg-primary-600 p-6 text-white">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold" id="paneTitle">Resource Details</h2>
            <button onclick="closeResourcePane()" class="p-2 hover:bg-white/20 rounded-lg transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></svg>
                </button>
        </div>
    </div>
    
    <div class="flex-1 overflow-hidden p-0 flex flex-col" id="paneContent">
        <div class="p-4 border-b bg-slate-50 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <span class="text-2xl" id="paneResourceIcon">📄</span>
                <div>
                    <h3 class="font-semibold text-slate-900" id="paneResourceTitle">Resource</h3>
                    <p class="text-sm text-slate-500" id="paneResourceMeta"></p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <button onclick="toggleView()" id="toggleViewBtn" class="p-2 hover:bg-slate-200 rounded-lg transition" title="Toggle view">
                    <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></svg>
                </button>
                <a href="#" id="paneOpenLink" target="_blank" class="p-2 hover:bg-slate-200 rounded-lg transition" title="Open in new tab">
                    <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></svg>
                </a>
            </div>
        </div>
        
        <div id="detailsView" class="flex-1 overflow-y-auto p-6">
            <div class="text-center text-slate-500 py-12">
                <svg class="w-16 h-16 mx-auto mb-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <p>Select a resource to view details</p>
            </div>
        </div>
        
        <div id="iframeView" class="flex-1 hidden">
            <iframe id="resourceIframe" src="" class="w-full h-full border-0"></iframe>
        </div>
    </div>
</div>

<div id="paneOverlay" class="fixed inset-0 bg-black/50 z-40 hidden" onclick="closeResourcePane()"></div>

<script>
let currentView = 'details';
let currentUrl = '';

function showResourcePane(resourceId) {
    const card = document.querySelector(`[data-resource-id="${resourceId}"]`);
    if (!card) return;
    
    const title = card.dataset.title;
    const description = card.dataset.description;
    const learningReason = card.dataset.learningReason;
    const url = card.dataset.url;
    const type = card.dataset.type;
    const duration = card.dataset.duration;
    const category = card.dataset.category;
    const difficulty = card.dataset.difficulty;
    
    currentUrl = url;
    currentView = 'details';
    
    document.getElementById('paneTitle').textContent = title;
    document.getElementById('paneOpenLink').href = url;
    
    const typeIcons = {
        'article': '📝',
        'video': '🎬',
        'tutorial': '📚',
        'documentation': '📖',
        'course': '🎓',
        'blog': '🌐'
    };
    
    const difficultyLabels = {
        '1': 'Beginner',
        '2': 'Intermediate', 
        '3': 'Advanced'
    };
    
    const difficultyColors = {
        '1': 'bg-green-100 text-green-700',
        '2': 'bg-yellow-100 text-yellow-700',
        '3': 'bg-red-100 text-red-700'
    };
    
    document.getElementById('paneResourceIcon').textContent = typeIcons[type] || '📄';
    document.getElementById('paneResourceTitle').textContent = title;
    document.getElementById('paneResourceMeta').textContent = `${category} · ${duration} min`;
    
    document.getElementById('detailsView').innerHTML = `
        <div class="space-y-6">
            <div class="flex items-center gap-3">
                <span class="text-4xl">${typeIcons[type] || '📄'}</span>
                <div>
                    <span class="text-sm px-3 py-1 bg-slate-100 rounded-full text-slate-600">${category}</span>
                    <span class="text-sm px-3 py-1 ml-2 rounded-full ${difficultyColors[difficulty] || 'bg-slate-100 text-slate-600'}">${difficultyLabels[difficulty] || 'Level ' + difficulty}</span>
                </div>
            </div>
            
            <div>
                <h3 class="text-lg font-semibold text-slate-900 mb-2">Description</h3>
                <p class="text-slate-600 leading-relaxed">${description}</p>
            </div>
            
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-slate-50 rounded-lg p-4 border border-slate-200">
                    <p class="text-sm text-slate-500 mb-1">Duration</p>
                    <p class="text-lg font-semibold text-slate-900">${duration} minutes</p>
                </div>
                <div class="bg-slate-50 rounded-lg p-4 border border-slate-200">
                    <p class="text-sm text-slate-500 mb-1">Type</p>
                    <p class="text-lg font-semibold text-slate-900 capitalize">${type}</p>
                </div>
            </div>
            
            <button onclick="loadIframe()" class="w-full btn-primary text-white py-3 px-6 rounded-lg font-medium flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                </svg>
                View in Iframe
            </button>
            
            ${learningReason ? `
            <div class="border-t pt-6">
                <h4 class="text-sm font-medium text-slate-500 mb-3">Why learn this</h4>
                <div class="bg-primary-50 border border-primary-100 rounded-lg p-4">
                    <div class="flex gap-3">
                        <svg class="w-5 h-5 text-primary-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-sm text-slate-700 leading-relaxed">${learningReason}</p>
                    </div>
                </div>
            </div>` : ''}
        </div>
    `;
    
    document.getElementById('detailsView').classList.remove('hidden');
    document.getElementById('iframeView').classList.add('hidden');
    
    document.getElementById('resourcePane').classList.remove('translate-x-full');
    document.getElementById('paneOverlay').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function loadIframe() {
    document.getElementById('resourceIframe').src = currentUrl;
    document.getElementById('detailsView').classList.add('hidden');
    document.getElementById('iframeView').classList.remove('hidden');
    currentView = 'iframe';
}

function toggleView() {
    if (currentView === 'details') {
        loadIframe();
    } else {
        document.getElementById('detailsView').classList.remove('hidden');
        document.getElementById('iframeView').classList.add('hidden');
        currentView = 'details';
    }
}

function closeResourcePane() {
    document.getElementById('resourcePane').classList.add('translate-x-full');
    document.getElementById('paneOverlay').classList.add('hidden');
    document.body.style.overflow = '';
    document.getElementById('resourceIframe').src = '';
    currentView = 'details';
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeResourcePane();
    }
});

// Hover popup
(function() {
    const popup = document.createElement('div');
    popup.className = 'resource-popup';
    document.body.appendChild(popup);

    let showTimer = null;
    let hideTimer = null;

    const difficultyLabels = { '1': 'Beginner', '2': 'Intermediate', '3': 'Advanced' };
    const difficultyColors = {
        '1': 'bg-green-100 text-green-700',
        '2': 'bg-yellow-100 text-yellow-700',
        '3': 'bg-red-100 text-red-700'
    };
    const typeIcons = {
        'article': '📝', 'video': '🎬', 'tutorial': '📚',
        'documentation': '📖', 'course': '🎓', 'blog': '🌐'
    };

    function positionPopup(cardEl) {
        const rect = cardEl.getBoundingClientRect();
        const popupW = 340;
        const gap = 12;
        let left = rect.right + gap;
        let top = rect.top;

        if (left + popupW > window.innerWidth - 16) {
            left = rect.left - popupW - gap;
        }
        if (left < 16) {
            left = 16;
        }
        if (top + 300 > window.innerHeight) {
            top = Math.max(16, window.innerHeight - 320);
        }

        popup.style.left = left + 'px';
        popup.style.top = top + 'px';
    }

    function showPopup(card) {
        const title = card.dataset.title;
        const desc = card.dataset.description;
        const learningReason = card.dataset.learningReason;
        const category = card.dataset.category;
        const difficulty = card.dataset.difficulty;
        const duration = card.dataset.duration;
        const type = card.dataset.type;
        const url = card.dataset.url;
        const icon = typeIcons[type] || '📄';
        const diffLabel = difficultyLabels[difficulty] || ('Level ' + difficulty);
        const diffColor = difficultyColors[difficulty] || 'bg-slate-100 text-slate-600';

        const reasonHtml = learningReason ? `
            <div class="mt-3 pt-3 border-t border-slate-100">
                <p class="text-xs font-medium text-primary-700 mb-1">Why learn this</p>
                <p class="text-xs text-slate-500 leading-relaxed line-clamp-2">${learningReason}</p>
            </div>` : '';

        popup.innerHTML = `
            <div class="popup-header">
                <div class="flex items-center gap-2 mb-2">
                    <span class="text-2xl">${icon}</span>
                    <span class="text-xs px-2 py-0.5 bg-slate-100 rounded text-slate-600">${category}</span>
                    <span class="text-xs px-2 py-0.5 rounded ${diffColor}">${diffLabel}</span>
                </div>
                <h4 class="text-base font-semibold text-slate-900 leading-snug">${title}</h4>
            </div>
            <div class="popup-body">
                <p class="text-sm text-slate-600 leading-relaxed line-clamp-3">${desc}</p>
                <div class="flex items-center gap-3 mt-3 text-xs text-slate-500">
                    <span class="flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        ${duration} min
                    </span>
                    <span class="capitalize flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                        ${type}
                    </span>
                </div>
                ${reasonHtml}
            </div>
            <div class="popup-footer">
                <button onclick="showResourcePane(${card.dataset.resourceId})"
                        class="w-full btn-primary text-white text-sm py-2 px-4 rounded-lg font-medium flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    Open Resource
                </button>
            </div>
        `;

        positionPopup(card);
        popup.classList.add('popup-visible');
    }

    function scheduleShow(card) {
        clearTimeout(hideTimer);
        clearTimeout(showTimer);
        showTimer = setTimeout(function() { showPopup(card); }, 220);
    }

    function scheduleHide() {
        clearTimeout(showTimer);
        hideTimer = setTimeout(function() {
            popup.classList.remove('popup-visible');
        }, 160);
    }

    document.querySelectorAll('.resource-card').forEach(function(card) {
        card.addEventListener('mouseenter', function() { scheduleShow(card); });
        card.addEventListener('mouseleave', function() { scheduleHide(); });
    });

    popup.addEventListener('mouseenter', function() { clearTimeout(hideTimer); });
    popup.addEventListener('mouseleave', function() { scheduleHide(); });
})();
</script>
@endsection
