@extends('layouts.app')

@section('content')
<style>
    /* Orange Theme Variables */
    :root {
        --orange-50: #fff7ed;
        --orange-100: #ffedd5;
        --orange-200: #fed7aa;
        --orange-300: #fdba74;
        --orange-400: #fb923c;
        --orange-500: #f97316;
        --orange-600: #ea580c;
        --orange-700: #c2410c;
        --orange-800: #9a360d;
        --orange-900: #7c2d12;

        --slate-50: #f8fafc;
        --slate-100: #f1f5f9;
        --slate-200: #e2e8f0;
        --slate-300: #cbd5e1;
        --slate-400: #94a3b8;
        --slate-500: #64748b;
        --slate-600: #475569;
        --slate-700: #334155;
        --slate-800: #1e293b;
        --slate-900: #0f172a;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        background: var(--slate-50);
        color: var(--slate-900);
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
    }

    /* Loading Overlay */
    #loading-overlay {
        position: fixed;
        inset: 0;
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        opacity: 1;
        transition: opacity 0.3s ease;
    }

    #loading-overlay.hidden {
        opacity: 0;
        pointer-events: none;
    }

    .spinner {
        width: 40px;
        height: 40px;
        border: 3px solid var(--slate-200);
        border-top-color: var(--orange-600);
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    /* Main Layout */
    .materials-container {
        display: grid;
        grid-template-columns: 280px 1fr;
        gap: 0;
        min-height: calc(100vh - 120px);
        margin-top: 0;
    }

    /* Sidebar */
    .sidebar {
        background: white;
        border-right: 1px solid var(--slate-200);
        padding: 24px 16px;
        position: fixed;
        left: 0;
        top: 80px;
        width: 280px;
        height: calc(100vh - 80px);
        overflow-y: auto;
    }

    .sidebar-title {
        font-size: 13px;
        font-weight: 600;
        text-transform: uppercase;
        color: var(--slate-500);
        letter-spacing: 0.5px;
        margin-bottom: 12px;
        margin-top: 20px;
    }

    .sidebar-title:first-child {
        margin-top: 0;
    }

    .sidebar-items {
        list-style: none;
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .sidebar-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 12px;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s ease;
        font-size: 14px;
        font-weight: 500;
        color: var(--slate-600);
        user-select: none;
    }

    .sidebar-item:hover {
        background: var(--orange-50);
        color: var(--orange-600);
    }

    .sidebar-item.active {
        background: linear-gradient(135deg, var(--orange-50), var(--orange-100));
        color: var(--orange-700);
        border-left: 3px solid var(--orange-600);
        padding-left: 9px;
    }

    .sidebar-item-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 20px;
        height: 20px;
        font-size: 16px;
    }

    .sidebar-count {
        margin-left: auto;
        background: var(--slate-100);
        color: var(--slate-600);
        font-size: 12px;
        font-weight: 600;
        padding: 2px 8px;
        border-radius: 12px;
    }

    .sidebar-item.active .sidebar-count {
        background: var(--orange-200);
        color: var(--orange-700);
    }

    /* Main Content */
    .main-content {
        margin-left: 280px;
        padding: 32px 24px;
    }

    .content-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 32px;
    }

    .content-title {
        font-size: 32px;
        font-weight: 700;
        color: var(--slate-900);
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .content-title-icon {
        font-size: 36px;
        display: flex;
        align-items: center;
    }

    .search-box {
        flex: 1;
        max-width: 400px;
        position: relative;
    }

    .search-box input {
        width: 100%;
        padding: 10px 12px 10px 36px;
        border: 1px solid var(--slate-200);
        border-radius: 8px;
        font-size: 14px;
        transition: all 0.2s ease;
    }

    .search-box input:focus {
        outline: none;
        border-color: var(--orange-500);
        box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.1);
    }

    .search-box::before {
        content: '🔍';
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 14px;
    }

    /* Controls */
    .controls {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        gap: 16px;
    }

    .sort-select {
        padding: 8px 12px;
        border: 1px solid var(--slate-200);
        border-radius: 6px;
        font-size: 14px;
        color: var(--slate-700);
        background: white;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .sort-select:hover {
        border-color: var(--orange-300);
    }

    .sort-select:focus {
        outline: none;
        border-color: var(--orange-500);
        box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.1);
    }

    /* Cards Grid */
    .cards-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 20px;
    }

    /* Card */
    .card {
        background: white;
        border: 1px solid var(--slate-200);
        border-radius: 12px;
        padding: 20px;
        transition: all 0.3s ease;
        cursor: pointer;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .card:hover {
        border-color: var(--orange-300);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.08);
        transform: translateY(-4px);
    }

    .card-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 8px;
    }

    .card-icon {
        font-size: 28px;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 44px;
        height: 44px;
        background: var(--orange-50);
        border-radius: 8px;
        flex-shrink: 0;
    }

    .card-title {
        font-size: 15px;
        font-weight: 600;
        color: var(--slate-900);
        word-break: break-word;
    }

    .card-category {
        display: inline-block;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        color: var(--orange-600);
        background: var(--orange-50);
        padding: 4px 8px;
        border-radius: 4px;
        letter-spacing: 0.5px;
    }

    .card-description {
        font-size: 13px;
        color: var(--slate-600);
        line-height: 1.5;
        flex: 1;
    }

    .card-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-top: 12px;
        border-top: 1px solid var(--slate-100);
        font-size: 12px;
        color: var(--slate-500);
    }

    /* Empty State */
    .empty-state {
        grid-column: 1 / -1;
        text-align: center;
        padding: 60px 20px;
        color: var(--slate-500);
    }

    .empty-state-icon {
        font-size: 48px;
        margin-bottom: 16px;
    }

    /* Modal */
    .modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1000;
        animation: fadeIn 0.2s ease;
    }

    .modal-overlay.active {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal {
        background: white;
        border-radius: 12px;
        max-width: 600px;
        max-height: 80vh;
        overflow-y: auto;
        width: 90%;
        position: relative;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    }

    .modal-close {
        position: absolute;
        top: 16px;
        right: 16px;
        background: none;
        border: none;
        font-size: 24px;
        cursor: pointer;
        color: var(--slate-400);
        transition: color 0.2s ease;
        z-index: 10;
    }

    .modal-close:hover {
        color: var(--slate-700);
    }

    .modal-content {
        padding: 32px;
    }

    .modal-title {
        font-size: 24px;
        font-weight: 700;
        color: var(--slate-900);
        margin-bottom: 8px;
    }

    .modal-category {
        display: inline-block;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        color: var(--orange-600);
        background: var(--orange-50);
        padding: 4px 8px;
        border-radius: 4px;
        margin-bottom: 16px;
    }

    .modal-body {
        font-size: 14px;
        line-height: 1.6;
        color: var(--slate-700);
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .materials-container {
            grid-template-columns: 1fr;
        }

        .sidebar {
            position: relative;
            top: auto;
            width: 100%;
            height: auto;
            border-right: none;
            border-bottom: 1px solid var(--slate-200);
            display: flex;
            gap: 24px;
            overflow-x: auto;
            overflow-y: hidden;
        }

        .sidebar-section {
            flex-shrink: 0;
        }

        .main-content {
            margin-left: 0;
            padding: 24px;
        }

        .cards-grid {
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        }
    }

    @media (max-width: 640px) {
        .content-title {
            font-size: 24px;
        }

        .cards-grid {
            grid-template-columns: 1fr;
        }

        .sidebar {
            flex-direction: column;
            gap: 0;
        }

        .sidebar-items {
            flex-direction: row;
            overflow-x: auto;
            gap: 8px;
        }

        .sidebar-item {
            white-space: nowrap;
            flex-shrink: 0;
        }
    }
</style>

<!-- Loading Overlay -->
<div id="loading-overlay">
    <div class="spinner"></div>
</div>

<!-- Main Container -->
<div class="materials-container">
    <!-- Sidebar Navigation -->
    <aside class="sidebar">
        <div class="sidebar-section">
            <div class="sidebar-title">Categories</div>
            <ul class="sidebar-items" id="sidebar-items">
                <li class="sidebar-item active" data-tab="skills">
                    <span class="sidebar-item-icon">✨</span>
                    <span>Skills</span>
                    <span class="sidebar-count">0</span>
                </li>
                <li class="sidebar-item" data-tab="agents">
                    <span class="sidebar-item-icon">🤖</span>
                    <span>Agents</span>
                    <span class="sidebar-count">0</span>
                </li>
                <li class="sidebar-item" data-tab="commands">
                    <span class="sidebar-item-icon">⌘</span>
                    <span>Commands</span>
                    <span class="sidebar-count">0</span>
                </li>
                <li class="sidebar-item" data-tab="mcps">
                    <span class="sidebar-item-icon">🔧</span>
                    <span>MCPs</span>
                    <span class="sidebar-count">0</span>
                </li>
                <li class="sidebar-item" data-tab="settings">
                    <span class="sidebar-item-icon">⚙️</span>
                    <span>Settings</span>
                    <span class="sidebar-count">0</span>
                </li>
                <li class="sidebar-item" data-tab="hooks">
                    <span class="sidebar-item-icon">🪝</span>
                    <span>Hooks</span>
                    <span class="sidebar-count">0</span>
                </li>
                <li class="sidebar-item" data-tab="templates">
                    <span class="sidebar-item-icon">📄</span>
                    <span>Templates</span>
                    <span class="sidebar-count">0</span>
                </li>
                <li class="sidebar-item" data-tab="plugins">
                    <span class="sidebar-item-icon">🧩</span>
                    <span>Plugins</span>
                    <span class="sidebar-count">0</span>
                </li>
            </ul>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <div class="content-header">
            <h1 class="content-title">
                <span class="content-title-icon" id="category-icon">✨</span>
                <span id="category-title">Skills</span>
            </h1>
            <div class="search-box">
                <input type="text" id="global-search" placeholder="Search...">
            </div>
        </div>

        <div class="controls">
            <select id="sort-select" class="sort-select">
                <option value="name-asc">Name (A-Z)</option>
                <option value="name-desc">Name (Z-A)</option>
                <option value="category-asc">Category (A-Z)</option>
                <option value="category-desc">Category (Z-A)</option>
            </select>
        </div>

        <div class="cards-grid" id="cards-grid">
            <div class="empty-state">
                <div class="empty-state-icon">📭</div>
                <p>No items found</p>
            </div>
        </div>
    </main>
</div>

<!-- Modal -->
<div class="modal-overlay" id="modal-overlay">
    <div class="modal">
        <button class="modal-close" onclick="closeModal()">×</button>
        <div class="modal-content" id="modal-body"></div>
    </div>
</div>

<script src="/claude-code-materials/app.js"></script>
@endsection
