@extends('layouts.app')

@section('content')
<style>
    .resource-card {
        display: flex;
        flex-direction: column;
        background: #fff;
        border: 1px solid #e8e5e0;
        border-left: 3px solid transparent;
        border-radius: 8px;
        padding: 20px;
        transition: border-left-color 0.15s ease, box-shadow 0.15s ease;
        cursor: pointer;
        position: relative;
    }
    .resource-card:hover {
        border-left-color: var(--orange-500);
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
    }
    .card-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        margin-bottom: 10px;
    }
    .card-badges {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
    }
    .card-badge {
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 3px 8px;
        border-radius: 4px;
        font-weight: 700;
        white-space: nowrap;
    }
    .badge-start { background: #dcfce7; color: #15803d; }
    .badge-docs  { background: #ccfbf1; color: #0f766e; }
    .badge-github { background: #e0e7ff; color: #4338ca; }
    .badge-course { background: #dbeafe; color: #1d4ed8; }
    .badge-channel { background: #fee2e2; color: #991b1b; }
    .badge-guide { background: #fef3c7; color: #92400e; }
    .badge-article { background: #f1f5f9; color: #475569; }
    .badge-video { background: #fce7f3; color: #9d174d; }
    .badge-tutorial { background: #dcfce7; color: #166534; }
    .badge-blog { background: #f3e8ff; color: #7c3aed; }
    .badge-tool { background: #e0e7ff; color: #3730a3; }
    .badge-book { background: #ffedd5; color: #c2410c; }
    .card-cat-pill {
        font-size: 11px;
        font-weight: 500;
        padding: 3px 8px;
        border-radius: 4px;
        background: var(--orange-50);
        color: var(--orange-700);
        border: 1px solid var(--orange-100);
    }
    .bookmark-btn {
        background: none;
        border: none;
        font-size: 18px;
        color: #94a3b8;
        cursor: pointer;
        padding: 2px;
        line-height: 1;
        transition: color 0.2s;
        flex-shrink: 0;
    }
    .bookmark-btn:hover,
    .bookmark-btn.bookmarked { color: var(--orange-500); }
    .card-title {
        font-size: 15px;
        font-weight: 600;
        color: #1c1917;
        margin-bottom: 4px;
        line-height: 1.35;
    }
    .card-meta {
        font-size: 12px;
        color: var(--slate-400);
        margin-bottom: 10px;
    }
    .card-desc {
        font-size: 13px;
        color: var(--slate-500);
        line-height: 1.5;
        flex-grow: 1;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        margin-bottom: 14px;
    }
    .card-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-top: 12px;
        border-top: 1px solid #f0ece8;
    }
    .complete-btn {
        font-size: 12px;
        font-weight: 500;
        padding: 6px 12px;
        border-radius: 6px;
        background: var(--slate-100);
        color: var(--slate-600);
        border: none;
        cursor: pointer;
        transition: all 0.2s;
    }
    .complete-btn:hover { background: var(--slate-200); }
    .complete-btn.completed { background: #22c55e; color: #fff; }
    .card-link {
        font-size: 13px;
        font-weight: 500;
        color: var(--orange-600);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: gap 0.15s;
    }
    .card-link:hover { gap: 8px; color: var(--orange-700); }
    /* Resource pane */
    .resource-popup {
        position: fixed;
        width: 340px;
        background: #fff;
        border-radius: 10px;
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
    .popup-header { padding: 16px 20px 12px; border-bottom: 1px solid #f1f5f9; }
    .popup-body   { padding: 12px 20px; }
    .popup-footer { padding: 12px 20px 16px; border-top: 1px solid #f1f5f9; }
    @media (hover: none) { .resource-popup { display: none !important; } }
</style>

<div class="app-header">
    <h1 class="app-title">📚 Learning Resources</h1>
    <p class="app-subtitle">{{ $resources->total() }} curated resources available</p>
</div>

<!-- Search + Filters -->
<div style="display: flex; align-items: center; justify-content: space-between; gap: 16px; margin-bottom: 16px; flex-wrap: wrap;">
    <div style="position: relative; max-width: 300px; width: 100%;">
        <svg style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); width: 16px; height: 16px; color: var(--slate-400);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
        </svg>
        <input type="text" id="searchInput" placeholder="Search resources…"
               value="{{ request('search') }}"
               style="width: 100%; padding: 8px 12px 8px 34px; border: 1px solid var(--slate-200); border-radius: 8px; font-size: 14px; outline: none; background: #fff;"
               onfocus="this.style.borderColor='var(--orange-500)'" onblur="this.style.borderColor='var(--slate-200)'">
    </div>
    <div style="display: flex; align-items: center; gap: 10px;">
        <select name="difficulty" onchange="applyFilters()"
                style="padding: 8px 12px; border: 1px solid var(--slate-200); border-radius: 8px; font-size: 13px; color: var(--slate-700); background: white; cursor: pointer;">
            <option value="">All Levels</option>
            <option value="1" {{ request('difficulty') == '1' ? 'selected' : '' }}>Beginner</option>
            <option value="2" {{ request('difficulty') == '2' ? 'selected' : '' }}>Intermediate</option>
            <option value="3" {{ request('difficulty') == '3' ? 'selected' : '' }}>Advanced</option>
        </select>
        <button onclick="clearFilters()"
                style="padding: 8px 14px; font-size: 13px; color: var(--slate-600); background: white; border: 1px solid var(--slate-200); border-radius: 8px; cursor: pointer;">
            Clear
        </button>
    </div>
</div>

<!-- Category Tabs -->
<div style="display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 24px; padding-bottom: 16px; border-bottom: 1px solid #e8e5e0;">
    <a href="{{ route('blogs.index', array_merge(request()->except('category', 'page'), ['category' => 'all'])) }}"
       style="display: inline-flex; align-items: center; gap: 5px; padding: 5px 13px; border-radius: 20px; font-size: 12.5px; font-weight: 500; text-decoration: none; transition: all 0.2s;
              {{ request('category', 'all') == 'all' ? 'background: var(--orange-600); color: white;' : 'background: var(--slate-100); color: var(--slate-600); border: 1px solid #e8e5e0;' }}">
        All Topics
    </a>
    @foreach($categories as $category)
    <a href="{{ route('blogs.index', array_merge(request()->except('category', 'page'), ['category' => $category])) }}"
       style="display: inline-flex; align-items: center; gap: 5px; padding: 5px 13px; border-radius: 20px; font-size: 12.5px; font-weight: 500; text-decoration: none; transition: all 0.2s;
              {{ request('category') == $category ? 'background: var(--orange-600); color: white;' : 'background: var(--slate-100); color: var(--slate-600); border: 1px solid #e8e5e0;' }}">
        {{ $category }}
        <span style="font-size: 11px; opacity: 0.75;">({{ $categoryCounts[$category] ?? 0 }})</span>
    </a>
    @endforeach
</div>

<!-- Count line -->
<p style="font-size: 13px; color: var(--slate-400); margin-bottom: 20px;">
    Showing {{ $resources->total() }} resources
    @if(request('category') && request('category') != 'all') in <strong style="color: var(--slate-600);">{{ request('category') }}</strong>@endif
</p>

<!-- Cards Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5" id="resourcesGrid">
    @forelse($resources as $resource)
        <div class="resource-card"
             data-resource-id="{{ $resource->id }}"
             data-url="{{ $resource->url }}"
             data-title="{{ $resource->title }}"
             data-description="{{ $resource->description }}"
             data-type="{{ strtolower($resource->type) }}"
             data-duration="{{ $resource->duration_minutes }}"
             data-category="{{ $resource->category }}"
             data-difficulty="{{ $resource->difficulty_level }}"
             data-learning-reason="{{ e($resource->learning_reason) }}"
             onclick="showResourcePane({{ $resource->id }})">
            <div class="card-header">
                <div class="card-badges">
                    @if($resource->difficulty_level == 1 && in_array($resource->category, ['Claude Code', 'Claude API', 'Claude Agent SDK', 'MCP', 'Prompt Engineering']))
                        <span class="card-badge badge-start">Start Here</span>
                    @endif
                    <span class="card-badge badge-{{ strtolower($resource->type) }}">{{ $resource->type }}</span>
                    <span class="card-cat-pill">{{ $resource->category }}</span>
                </div>
                <button class="bookmark-btn {{ in_array($resource->id, $completedIds ?? []) ? 'bookmarked' : '' }}"
                        data-id="{{ $resource->id }}"
                        onclick="event.stopPropagation();">
                    {{ in_array($resource->id, $completedIds ?? []) ? '★' : '☆' }}
                </button>
            </div>
            <h3 class="card-title">{{ $resource->title }}</h3>
            <div class="card-meta">{{ $resource->duration_minutes }} min · Level {{ $resource->difficulty_level }}</div>
            <p class="card-desc">{{ $resource->description }}</p>
            <div class="card-footer">
                <button class="complete-btn {{ in_array($resource->id, $completedIds ?? []) ? 'completed' : '' }}"
                        data-id="{{ $resource->id }}"
                        onclick="event.stopPropagation();">
                    {{ in_array($resource->id, $completedIds ?? []) ? 'Completed ✓' : 'Mark Complete' }}
                </button>
                @if($resource->url)
                <a class="card-link" href="{{ $resource->url }}" target="_blank" rel="noopener noreferrer" onclick="event.stopPropagation();">
                    Open →
                </a>
                @endif
            </div>
        </div>
    @empty
        <div class="col-span-full text-center py-16">
            <div style="font-size: 40px; margin-bottom: 12px;">🔍</div>
            <p style="color: var(--slate-400); font-size: 15px;">No resources found matching your criteria.</p>
            <a href="{{ route('blogs.index') }}" style="display: inline-block; margin-top: 12px; color: var(--orange-600); font-size: 14px;">Clear filters →</a>
        </div>
    @endforelse
</div>

<!-- Pagination -->
<div class="mt-8">
    {{ $resources->withQueryString()->links() }}
</div>

<!-- Detail Pane -->
<div id="resourcePane" class="fixed inset-y-0 right-0 w-full md:w-[580px] bg-white shadow-2xl transform translate-x-full transition-transform duration-300 z-50 overflow-hidden flex flex-col" style="border-left: 1px solid #e8e5e0;">
    <div class="p-5 text-white flex items-center justify-between" style="background: var(--orange-600);">
        <h2 class="text-lg font-bold" id="paneTitle">Resource Details</h2>
        <button onclick="closeResourcePane()" class="p-1.5 hover:bg-white/20 rounded transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    <div class="p-4 border-b bg-slate-50 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <span class="text-2xl" id="paneIcon">📄</span>
            <div>
                <p class="font-semibold text-slate-900 text-sm" id="paneResourceTitle">Resource</p>
                <p class="text-xs text-slate-400" id="paneResourceMeta"></p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <button onclick="toggleView()" id="toggleViewBtn" class="p-1.5 hover:bg-slate-200 rounded transition" title="Toggle view">
                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                </svg>
            </button>
            <a href="#" id="paneOpenLink" target="_blank" class="p-1.5 hover:bg-slate-200 rounded transition" title="Open in new tab">
                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                </svg>
            </a>
        </div>
    </div>

    <div id="detailsView" class="flex-1 overflow-y-auto p-6">
        <div class="text-center text-slate-400 py-12">
            <div style="font-size: 40px; margin-bottom: 12px;">📄</div>
            <p>Select a resource to view details</p>
        </div>
    </div>

    <div id="iframeView" class="flex-1 hidden">
        <iframe id="resourceIframe" src="" class="w-full h-full border-0"></iframe>
    </div>
</div>

<div id="paneOverlay" class="fixed inset-0 bg-black/50 z-40 hidden" onclick="closeResourcePane()"></div>

<!-- Hover popup -->
<div class="resource-popup" id="hoverPopup"></div>

<script>
function applyFilters() {
    const difficulty = document.querySelector('select[name="difficulty"]').value;
    const url = new URL(window.location.href);
    difficulty ? url.searchParams.set('difficulty', difficulty) : url.searchParams.delete('difficulty');
    window.location.href = url.toString();
}

function clearFilters() {
    const url = new URL(window.location.href);
    url.searchParams.delete('difficulty');
    url.searchParams.delete('search');
    window.location.href = url.toString();
}

document.getElementById('searchInput').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        const url = new URL(window.location.href);
        this.value ? url.searchParams.set('search', this.value) : url.searchParams.delete('search');
        window.location.href = url.toString();
    }
});

let currentView = 'details', currentUrl = '';

const typeIcons = { article:'📝', video:'🎬', tutorial:'📚', documentation:'📖', course:'🎓', blog:'🌐', skills:'✨', agents:'🤖', commands:'⌘', mcps:'🔧', settings:'⚙️', hooks:'🪝', templates:'📄', plugins:'🧩' };
const diffLabels = { '1':'Beginner', '2':'Intermediate', '3':'Advanced' };
const diffColors = { '1':'background:#dcfce7;color:#166534', '2':'background:#fef9c3;color:#854d0e', '3':'background:#fee2e2;color:#991b1b' };

function showResourcePane(resourceId) {
    const card = document.querySelector(`[data-resource-id="${resourceId}"]`);
    if (!card) return;

    const { title, description, learningReason, url, type, duration, category, difficulty } = card.dataset;
    currentUrl = url;
    currentView = 'details';

    document.getElementById('paneTitle').textContent = title;
    document.getElementById('paneOpenLink').href = url || '#';
    document.getElementById('paneIcon').textContent = typeIcons[type] || '📄';
    document.getElementById('paneResourceTitle').textContent = title;
    document.getElementById('paneResourceMeta').textContent = `${category} · ${duration} min`;

    document.getElementById('detailsView').innerHTML = `
        <div class="space-y-5">
            <div class="flex items-center gap-3">
                <span class="text-4xl">${typeIcons[type] || '📄'}</span>
                <div class="flex gap-2">
                    <span style="font-size:12px;padding:3px 10px;border-radius:20px;background:var(--orange-50);color:var(--orange-700);border:1px solid var(--orange-100);">${category}</span>
                    <span style="font-size:12px;padding:3px 10px;border-radius:20px;${diffColors[difficulty] || ''}">${diffLabels[difficulty] || 'Level ' + difficulty}</span>
                </div>
            </div>
            <div>
                <h3 style="font-size:15px;font-weight:600;color:#1c1917;margin-bottom:8px;">Description</h3>
                <p style="font-size:14px;color:var(--slate-500);line-height:1.6;">${description}</p>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                <div style="background:#f8f8f6;border-radius:8px;padding:14px;border:1px solid #e8e5e0;">
                    <p style="font-size:11px;color:var(--slate-400);margin-bottom:4px;text-transform:uppercase;letter-spacing:0.5px;">Duration</p>
                    <p style="font-size:16px;font-weight:600;color:#1c1917;">${duration} min</p>
                </div>
                <div style="background:#f8f8f6;border-radius:8px;padding:14px;border:1px solid #e8e5e0;">
                    <p style="font-size:11px;color:var(--slate-400);margin-bottom:4px;text-transform:uppercase;letter-spacing:0.5px;">Type</p>
                    <p style="font-size:16px;font-weight:600;color:#1c1917;text-transform:capitalize;">${type}</p>
                </div>
            </div>
            ${url ? `<button onclick="loadIframe()" class="btn-primary w-full" style="justify-content:center;padding:10px 16px;">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                View Resource
            </button>` : ''}
            ${learningReason ? `<div style="border-top:1px solid #e8e5e0;padding-top:16px;">
                <p style="font-size:12px;font-weight:600;color:var(--slate-400);text-transform:uppercase;letter-spacing:0.5px;margin-bottom:8px;">Why learn this</p>
                <div style="background:var(--orange-50);border:1px solid var(--orange-100);border-radius:8px;padding:14px;">
                    <p style="font-size:13px;color:var(--slate-600);line-height:1.6;">${learningReason}</p>
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
    currentView === 'details' ? loadIframe() : (() => {
        document.getElementById('detailsView').classList.remove('hidden');
        document.getElementById('iframeView').classList.add('hidden');
        currentView = 'details';
    })();
}

function closeResourcePane() {
    document.getElementById('resourcePane').classList.add('translate-x-full');
    document.getElementById('paneOverlay').classList.add('hidden');
    document.body.style.overflow = '';
    document.getElementById('resourceIframe').src = '';
    currentView = 'details';
}

document.addEventListener('keydown', e => { if (e.key === 'Escape') closeResourcePane(); });

// Hover popup
(function() {
    const popup = document.getElementById('hoverPopup');
    let showTimer = null, hideTimer = null;

    function positionPopup(card) {
        const rect = card.getBoundingClientRect();
        const gap = 12, pw = 340;
        let left = rect.right + gap;
        let top = rect.top;
        if (left + pw > window.innerWidth - 16) left = rect.left - pw - gap;
        if (left < 16) left = 16;
        if (top + 300 > window.innerHeight) top = Math.max(16, window.innerHeight - 320);
        popup.style.left = left + 'px';
        popup.style.top = top + window.scrollY + 'px';
    }

    function showPopup(card) {
        const { title, description, learningReason, category, difficulty, duration, type } = card.dataset;
        const icon = typeIcons[type] || '📄';
        const diffLabel = diffLabels[difficulty] || ('Level ' + difficulty);
        const diffStyle = diffColors[difficulty] || '';

        popup.innerHTML = `
            <div class="popup-header">
                <div style="display:flex;align-items:center;gap:8px;margin-bottom:8px;">
                    <span style="font-size:22px;">${icon}</span>
                    <span style="font-size:11px;padding:2px 8px;border-radius:20px;background:var(--orange-50);color:var(--orange-700);">${category}</span>
                    <span style="font-size:11px;padding:2px 8px;border-radius:20px;${diffStyle}">${diffLabel}</span>
                </div>
                <h4 style="font-size:14px;font-weight:600;color:#1c1917;line-height:1.35;">${title}</h4>
            </div>
            <div class="popup-body">
                <p style="font-size:12.5px;color:var(--slate-500);line-height:1.5;">${description ? description.substring(0,160) + (description.length > 160 ? '…' : '') : ''}</p>
                <div style="display:flex;gap:12px;margin-top:10px;font-size:11.5px;color:var(--slate-400);">
                    <span>⏱ ${duration} min</span>
                    <span style="text-transform:capitalize;">📁 ${type}</span>
                </div>
            </div>
            <div class="popup-footer">
                <button onclick="showResourcePane(${card.dataset.resourceId})"
                        class="btn-primary" style="width:100%;justify-content:center;font-size:13px;padding:8px 16px;">
                    View Details →
                </button>
            </div>`;

        positionPopup(card);
        popup.classList.add('popup-visible');
    }

    document.querySelectorAll('.resource-card').forEach(card => {
        card.addEventListener('mouseenter', () => {
            clearTimeout(hideTimer);
            clearTimeout(showTimer);
            showTimer = setTimeout(() => showPopup(card), 220);
        });
        card.addEventListener('mouseleave', () => {
            clearTimeout(showTimer);
            hideTimer = setTimeout(() => popup.classList.remove('popup-visible'), 160);
        });
    });

    popup.addEventListener('mouseenter', () => clearTimeout(hideTimer));
    popup.addEventListener('mouseleave', () => {
        hideTimer = setTimeout(() => popup.classList.remove('popup-visible'), 160);
    });
})();
</script>
@endsection
