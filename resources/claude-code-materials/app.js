/* Claude Code Materials - Modern UI */

let DB = {};
const ITEMS_PER_PAGE = 24;
const TAB_TYPES = ['skills', 'agents', 'commands', 'mcps', 'settings', 'hooks', 'templates', 'plugins'];

const CATEGORY_INFO = {
  skills: { icon: '✨', label: 'Skills' },
  agents: { icon: '🤖', label: 'Agents' },
  commands: { icon: '⌘', label: 'Commands' },
  mcps: { icon: '🔧', label: 'MCPs' },
  settings: { icon: '⚙️', label: 'Settings' },
  hooks: { icon: '🪝', label: 'Hooks' },
  templates: { icon: '📄', label: 'Templates' },
  plugins: { icon: '🧩', label: 'Plugins' }
};

const TAB_COLORS = {
  skills: '#ea580c', agents: '#f97316', commands: '#fb923c',
  mcps: '#fdba74', settings: '#fed7aa', hooks: '#ea580c',
  templates: '#f97316', plugins: '#fb923c'
};

// Per-tab state
const tabState = {};
TAB_TYPES.forEach(t => {
  tabState[t] = { page: 1, search: '', category: 'all', filtered: [], sortBy: 'name-asc' };
});

let activeTab = 'skills';

// DOM Ready
document.addEventListener('DOMContentLoaded', () => {
  // Wait for all elements to be parsed
  setTimeout(() => {
    loadData();
  }, 100);
});

// Load Data
async function loadData() {
  const overlay = document.getElementById('loading-overlay');
  try {
    const resp = await fetch('/data.json');
    if (!resp.ok) throw new Error('Failed to load data.json');
    DB = await resp.json();
    if (overlay) overlay.classList.add('hidden');
    initApp();
  } catch (err) {
    console.error('Error loading data:', err);
    if (overlay) {
      overlay.innerHTML = `<div style="text-align:center; color: #e65100;">Error loading materials: ${err.message}</div>`;
    }
  }
}

// Initialize App
function initApp() {
  // Update sidebar counts
  updateSidebarCounts();

  // Setup sidebar navigation
  setupSidebarNav();

  // Setup search
  setupSearch();

  // Setup sort
  setupSort();

  // Initial render
  renderContent(activeTab);
}

// Update sidebar counts
function updateSidebarCounts() {
  TAB_TYPES.forEach(type => {
    const count = getItems(type).length;
    const countEl = document.querySelector(`.sidebar-item[data-tab="${type}"] .sidebar-count`);
    if (countEl) countEl.textContent = count;
  });
}

// Setup sidebar navigation
function setupSidebarNav() {
  document.querySelectorAll('.sidebar-item').forEach(item => {
    item.addEventListener('click', () => {
      const tab = item.dataset.tab;
      if (tab && TAB_TYPES.includes(tab)) {
        switchTab(tab);
      }
    });
  });
}

// Switch tab
function switchTab(type) {
  if (!TAB_TYPES.includes(type)) return;

  activeTab = type;

  // Update sidebar active state
  document.querySelectorAll('.sidebar-item').forEach(item => {
    item.classList.remove('active');
  });
  document.querySelector(`.sidebar-item[data-tab="${type}"]`).classList.add('active');

  // Update title and icon
  const info = CATEGORY_INFO[type];
  document.getElementById('category-icon').textContent = info.icon;
  document.getElementById('category-title').textContent = info.label;

  // Render content
  renderContent(type);
}

// Get items for type
function getItems(type, sortBy = 'name-asc') {
  let items = DB[type];
  if (!items) return [];
  if (Array.isArray(items)) items = [...items];
  else items = Object.values(items);

  return sortItems(items, sortBy);
}

// Sort items
function sortItems(items, sortBy) {
  return items.sort((a, b) => {
    switch (sortBy) {
      case 'name-asc':
        return (a.name || '').localeCompare(b.name || '');
      case 'name-desc':
        return (b.name || '').localeCompare(a.name || '');
      case 'category-asc':
        return (a.category || '').localeCompare(b.category || '');
      case 'category-desc':
        return (b.category || '').localeCompare(a.category || '');
      default:
        return 0;
    }
  });
}

// Render content
function renderContent(type) {
  const grid = document.getElementById('cards-grid');
  if (!grid) {
    console.error('cards-grid element not found');
    return;
  }

  const state = tabState[type];
  const allItems = getItems(type, state.sortBy);

  // Filter items
  let items = [...allItems];

  if (state.search) {
    const q = state.search.toLowerCase();
    items = items.filter(i =>
      (i.name || '').toLowerCase().includes(q) ||
      (i.description || '').toLowerCase().includes(q) ||
      (i.category || '').toLowerCase().includes(q) ||
      (i.keywords || []).some(k => k.toLowerCase().includes(q))
    );
  }

  state.filtered = items;

  // Pagination
  const totalPages = Math.max(1, Math.ceil(items.length / ITEMS_PER_PAGE));
  if (state.page > totalPages) state.page = totalPages;
  const start = (state.page - 1) * ITEMS_PER_PAGE;
  const pageItems = items.slice(start, start + ITEMS_PER_PAGE);

  // Render grid
  if (pageItems.length === 0) {
    grid.innerHTML = `
      <div class="empty-state">
        <div class="empty-state-icon">🔍</div>
        <p>No items found</p>
      </div>
    `;
    return;
  }

  let html = pageItems.map((item, idx) => renderCard(item, type, start + idx)).join('');
  grid.innerHTML = html;

  // Bind card events
  document.querySelectorAll('.card').forEach(card => {
    card.addEventListener('click', () => {
      const type = card.dataset.type;
      const index = parseInt(card.dataset.index);
      openDetail(type, index);
    });
  });
}

// Render card
function renderCard(item, type, index) {
  const name = item.name || 'Untitled';
  const desc = item.description || '';
  const shortDesc = desc.length > 100 ? desc.substring(0, 100) + '...' : desc;
  const category = item.category || '';
  const catLabel = category.replace(/-/g, ' ').replace(/\b\w/g, c => c.toUpperCase());

  return `
    <div class="card" data-type="${type}" data-index="${index}">
      <div class="card-header">
        <div class="card-icon">📚</div>
        <div>
          <div class="card-title">${escapeHtml(name)}</div>
          ${category ? `<div class="card-category">${escapeHtml(catLabel)}</div>` : ''}
        </div>
      </div>
      <div class="card-description">${escapeHtml(shortDesc)}</div>
      <div class="card-footer">
        <span>${item.downloads ? item.downloads + ' downloads' : 'New'}</span>
        <span style="color: ${TAB_COLORS[type] || '#ea580c'};">→</span>
      </div>
    </div>
  `;
}

// Setup search
function setupSearch() {
  const searchBox = document.getElementById('global-search');
  if (searchBox) {
    let debounce;
    searchBox.addEventListener('input', (e) => {
      clearTimeout(debounce);
      debounce = setTimeout(() => {
        tabState[activeTab].search = e.target.value.trim();
        tabState[activeTab].page = 1;
        renderContent(activeTab);
      }, 300);
    });
  }
}

// Setup sort
function setupSort() {
  const sortSelect = document.getElementById('sort-select');
  if (sortSelect) {
    sortSelect.addEventListener('change', (e) => {
      const sortBy = e.target.value;
      tabState[activeTab].sortBy = sortBy;
      tabState[activeTab].page = 1;
      renderContent(activeTab);
    });
  }
}

// Open detail modal
function openDetail(type, index) {
  const items = getItems(type, tabState[type].sortBy);
  const item = items[index];
  if (!item) return;

  const name = item.name || 'Untitled';
  const desc = item.description || 'No description available';
  const category = item.category || '';
  const catLabel = category.replace(/-/g, ' ').replace(/\b\w/g, c => c.toUpperCase());

  const modalBody = document.getElementById('modal-body');
  if (!modalBody) {
    console.error('modal-body element not found');
    return;
  }

  modalBody.innerHTML = `
    <div class="modal-title">${escapeHtml(name)}</div>
    ${category ? `<div class="modal-category">${escapeHtml(catLabel)}</div>` : ''}
    <div class="modal-body">${desc.split('\n').map(p => `<p>${escapeHtml(p)}</p>`).join('')}</div>
  `;

  const overlay = document.getElementById('modal-overlay');
  if (overlay) {
    overlay.classList.add('active');
  }
}

// Close modal
function closeModal() {
  const overlay = document.getElementById('modal-overlay');
  if (overlay) {
    overlay.classList.remove('active');
  }
}

// Close modal on overlay click
document.addEventListener('DOMContentLoaded', () => {
  const overlay = document.getElementById('modal-overlay');
  if (overlay) {
    overlay.addEventListener('click', (e) => {
      if (e.target === overlay) closeModal();
    });
  }
});

// Escape key to close modal
document.addEventListener('keydown', (e) => {
  if (e.key === 'Escape') closeModal();
});

// Utility: Escape HTML
function escapeHtml(text) {
  const map = {
    '&': '&amp;',
    '<': '&lt;',
    '>': '&gt;',
    '"': '&quot;',
    "'": '&#039;'
  };
  return text.replace(/[&<>"']/g, m => map[m]);
}
