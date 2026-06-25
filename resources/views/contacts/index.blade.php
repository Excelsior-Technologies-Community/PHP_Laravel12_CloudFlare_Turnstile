<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submitted Contacts</title>
    <style>
        :root {
            --bg: #f1f5f9;
            --card-bg: #ffffff;
            --card-border: #e2e8f0;
            --title-color: #0f172a;
            --sub-text: #64748b;
            --back-btn-bg: linear-gradient(135deg, #6366f1, #8b5cf6);
            --input-bg: #f1f5f9;
            --input-color: #0f172a;
            --input-placeholder: #94a3b8;
            --search-btn-bg: linear-gradient(135deg, #3b82f6, #6366f1);
            --table-head-bg: #f1f5f9;
            --table-head-color: #374151;
            --table-row-border: #e2e8f0;
            --table-row-hover: #f8fafc;
            --table-cell-color: #374151;
            --id-badge-bg: #6366f1;
            --message-color: #64748b;
            --del-btn-bg: linear-gradient(135deg, #ef4444, #dc2626);
            --empty-color: #94a3b8;
            --pagination-bg: #e2e8f0;
            --pagination-active: #6366f1;
            --pagination-color: #374151;
            --success-bg: #dcfce7;
            --success-text: #166534;
            --success-border: #86efac;
            --dropdown-bg: #ffffff;
            --dropdown-border: #e2e8f0;
            --dropdown-hover: #f1f5f9;
            --dropdown-text: #374151;
            --dropdown-match: #6366f1;
            --toggle-card: #ffffff;
            --toggle-border: #e2e8f0;
            --highlight-bg: rgba(99,102,241,0.12);
        }
        [data-theme="dark"] {
            --bg: #0f172a;
            --card-bg: #1e293b;
            --card-border: rgba(255,255,255,0.08);
            --title-color: #f1f5f9;
            --sub-text: #cbd5e1;
            --back-btn-bg: linear-gradient(135deg, #6366f1, #8b5cf6);
            --input-bg: #334155;
            --input-color: #f1f5f9;
            --input-placeholder: #cbd5e1;
            --search-btn-bg: linear-gradient(135deg, #3b82f6, #6366f1);
            --table-head-bg: #334155;
            --table-head-color: #f1f5f9;
            --table-row-border: #334155;
            --table-row-hover: #273449;
            --table-cell-color: #e2e8f0;
            --id-badge-bg: #6366f1;
            --message-color: #cbd5e1;
            --del-btn-bg: linear-gradient(135deg, #ef4444, #dc2626);
            --empty-color: #cbd5e1;
            --pagination-bg: #334155;
            --pagination-active: #6366f1;
            --pagination-color: #f1f5f9;
            --success-bg: #14532d;
            --success-text: #dcfce7;
            --success-border: #22c55e;
            --dropdown-bg: #1e293b;
            --dropdown-border: #475569;
            --dropdown-hover: #334155;
            --dropdown-text: #e2e8f0;
            --dropdown-match: #a5b4fc;
            --toggle-card: #1e293b;
            --toggle-border: #475569;
            --highlight-bg: rgba(99,102,241,0.2);
        }

        * { margin:0; padding:0; box-sizing:border-box; font-family:Arial, sans-serif; }
        body { background: var(--bg); min-height:100vh; padding:40px 20px; color: var(--title-color); transition: background 0.3s; }
        .container { max-width:1200px; margin:auto; }

        .header { display:flex; justify-content:space-between; align-items:center; margin-bottom:30px; flex-wrap:wrap; gap:15px; }
        .title-box h1 { font-size:38px; font-weight:bold; color: var(--title-color); }
        .title-box p { color: var(--sub-text); margin-top:8px; }
        .header-right { display:flex; gap:12px; align-items:center; }

        .theme-toggle {
            display:flex; align-items:center; gap:8px;
            background: var(--toggle-card); border:1px solid var(--toggle-border);
            border-radius:30px; padding:8px 14px; cursor:pointer;
            box-shadow:0 2px 8px rgba(0,0,0,0.15); transition: background 0.3s, border 0.3s;
            color: var(--title-color); font-weight:bold; font-size:13px;
        }

        .back-btn {
            text-decoration:none; background: var(--back-btn-bg); color:white;
            padding:12px 22px; border-radius:12px; font-weight:bold; transition:0.3s;
        }
        .back-btn:hover { transform:translateY(-2px); opacity:0.9; }

        .card {
            background: var(--card-bg); border-radius:20px; padding:25px;
            box-shadow:0 10px 30px rgba(0,0,0,0.4); border:1px solid var(--card-border);
            transition: background 0.3s;
        }

        .top-bar { display:flex; justify-content:space-between; align-items:center; margin-bottom:25px; flex-wrap:wrap; gap:15px; }
        .search-wrapper { position:relative; display:flex; gap:12px; flex-wrap:wrap; }
        .search-input-wrap { position:relative; }

        .search-box input {
            width:300px; padding:14px 14px 14px 42px; border:2px solid transparent;
            border-radius:12px; background: var(--input-bg); color: var(--input-color);
            outline:none; font-size:15px; transition: background 0.3s, border 0.3s;
        }
        .search-box input:focus { border-color: #6366f1; }
        .search-box input::placeholder { color: var(--input-placeholder); }

        .search-icon {
            position:absolute; left:14px; top:50%; transform:translateY(-50%);
            color: var(--input-placeholder); font-size:16px; pointer-events:none;
        }

        .search-status {
            position:absolute; right:12px; top:50%; transform:translateY(-50%);
            font-size:11px; color: var(--sub-text); white-space:nowrap;
        }

        .search-box button {
            padding:14px 22px; border:none; border-radius:12px;
            background: var(--search-btn-bg); color:white; cursor:pointer;
            font-weight:bold; transition:0.3s;
        }
        .search-box button:hover { transform:scale(1.04); }

        /* ─── Suggestions Dropdown ─── */
        .suggestions-dropdown {
            position:absolute; top:calc(100% + 6px); left:0;
            width:340px; background: var(--dropdown-bg);
            border:1px solid var(--dropdown-border); border-radius:14px;
            box-shadow:0 12px 32px rgba(0,0,0,0.18); z-index:200;
            overflow:hidden; display:none;
        }
        .suggestions-dropdown.show { display:block; }

        .sug-section-label {
            font-size:10px; font-weight:bold; text-transform:uppercase;
            letter-spacing:0.8px; color: var(--sub-text);
            padding:10px 14px 4px;
        }

        .sug-item {
            display:flex; align-items:center; gap:10px;
            padding:9px 14px; cursor:pointer;
            color: var(--dropdown-text); font-size:14px;
            transition: background 0.15s;
            border-left:3px solid transparent;
        }
        .sug-item:hover, .sug-item.active {
            background: var(--highlight-bg);
            border-left-color: #6366f1;
        }
        .sug-item .sug-ico { font-size:13px; flex-shrink:0; opacity:0.55; }
        .sug-item .sug-text { flex:1; min-width:0; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }
        .sug-item .sug-text mark {
            background:none; color: var(--dropdown-match);
            font-weight:bold; padding:0;
        }
        .sug-item .sug-meta { font-size:11px; color: var(--sub-text); flex-shrink:0; }
        .sug-item .sug-del {
            margin-left:4px; font-size:11px; opacity:0; cursor:pointer;
            padding:2px 7px; border-radius:6px; flex-shrink:0;
            transition: opacity 0.15s, background 0.15s;
        }
        .sug-item:hover .sug-del { opacity:0.5; }
        .sug-item .sug-del:hover { opacity:1 !important; background:rgba(239,68,68,0.15); color:#ef4444; }

        .sug-divider { height:1px; background: var(--dropdown-border); margin:4px 0; }

        .sug-footer {
            padding:8px 14px 10px; display:flex; justify-content:space-between; align-items:center;
        }
        .sug-footer span { font-size:11px; color: var(--sub-text); }
        .sug-clear { font-size:11px; color:#ef4444; cursor:pointer; font-weight:bold; }
        .sug-clear:hover { text-decoration:underline; }

        .sug-empty { padding:14px; text-align:center; font-size:13px; color: var(--sub-text); }

        .success {
            background: var(--success-bg); border:1px solid var(--success-border);
            color: var(--success-text); padding:16px; border-radius:14px; margin-bottom:20px;
        }

        /* ─── Live search result count ─── */
        .result-info { font-size:13px; color: var(--sub-text); padding:0 0 14px; }
        .result-info strong { color: var(--title-color); }

        .table-wrapper { overflow-x:auto; }
        table { width:100%; border-collapse:collapse; min-width:900px; }
        table th { background: var(--table-head-bg); color: var(--table-head-color); padding:16px; text-align:left; font-size:15px; }
        table td { padding:18px 16px; border-bottom:1px solid var(--table-row-border); color: var(--table-cell-color); transition: background 0.15s; }
        table tr:hover td { background: var(--table-row-hover); }
        table tr.hidden-row { display:none; }

        /* highlight matched text inside table cells */
        .cell-highlight { background: var(--highlight-bg); border-radius:3px; padding:0 2px; color: var(--dropdown-match); font-weight:bold; }

        .id-badge { background: var(--id-badge-bg); padding:6px 12px; border-radius:30px; font-size:13px; font-weight:bold; display:inline-block; color:white; }
        .message-box { max-width:300px; line-height:1.6; color: var(--message-color); }
        .delete-btn { border:none; padding:10px 18px; border-radius:10px; background: var(--del-btn-bg); color:white; cursor:pointer; font-weight:bold; transition:0.3s; }
        .delete-btn:hover { transform:scale(1.05); }
        .empty { text-align:center; padding:30px; color: var(--empty-color); }
        .no-results-row { display:none; }
        .no-results-row.show { display:table-row; }

        .pagination { margin-top:35px; display:flex; justify-content:center; gap:10px; flex-wrap:wrap; }
        .pagination a { text-decoration:none; padding:12px 18px; border-radius:10px; background: var(--pagination-bg); color: var(--pagination-color); transition:0.3s; }
        .pagination a:hover { background: var(--pagination-active); color:white; }
        .pagination span { padding:12px 18px; border-radius:10px; background: var(--pagination-active); color:white; font-weight:bold; }
        .disabled { opacity:0.5; pointer-events:none; }

        #paginationSection.hidden { display:none; }

        @media(max-width:768px) {
            body { padding:20px 12px; }
            .header { flex-direction:column; align-items:flex-start; }
            .top-bar { flex-direction:column; align-items:stretch; }
            .search-wrapper { width:100%; }
            .search-input-wrap { width:100%; }
            .search-box input { width:100%; }
            .suggestions-dropdown { width:100%; }
        }
    </style>
</head>
<body>

<div class="container">

    <div class="header">
        <div class="title-box">
            <h1>Submitted Contacts</h1>
            <p>Manage all submitted contact messages easily</p>
        </div>
        <div class="header-right">
            <button class="theme-toggle" onclick="toggleTheme()" aria-label="Toggle theme">
                <span id="theme-icon">☀️</span>
                <span id="theme-label">Light</span>
            </button>
            <a href="{{ route('contact.form') }}" class="back-btn">+ Back To Form</a>
        </div>
    </div>

    <div class="card">

        @if(session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif

        <div class="top-bar">
            <div class="search-wrapper">
                <form action="{{ route('contacts.index') }}" method="GET" class="search-box" id="searchForm">
                    <div class="search-input-wrap">
                        <span class="search-icon">🔍</span>
                        <input
                            type="text"
                            name="search"
                            id="searchInput"
                            value="{{ request('search') }}"
                            placeholder="Search name, email or message..."
                            autocomplete="off"
                        >
                        <span class="search-status" id="searchStatus"></span>
                        <div class="suggestions-dropdown" id="suggestionsDropdown"></div>
                    </div>
                    <button type="submit">Search</button>
                </form>
            </div>
        </div>

        <div class="result-info" id="resultInfo" style="display:none;"></div>

        <div class="table-wrapper">
            <table id="contactsTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Message</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                @forelse($contacts as $contact)
                    <tr
                        data-name="{{ strtolower($contact->name) }}"
                        data-email="{{ strtolower($contact->email) }}"
                        data-message="{{ strtolower($contact->message) }}"
                    >
                        <td><span class="id-badge">#{{ $contact->id }}</span></td>
                        <td class="col-name">{{ $contact->name }}</td>
                        <td class="col-email">{{ $contact->email }}</td>
                        <td><div class="message-box col-message">{{ $contact->message }}</div></td>
                        <td>
                            <form action="{{ route('contacts.destroy', $contact->id) }}" method="POST" onsubmit="return confirm('Delete this contact?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete-btn">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="empty">No contacts found.</td>
                    </tr>
                @endforelse
                    <tr class="no-results-row" id="noResultsRow">
                        <td colspan="5" class="empty">No contacts match your search.</td>
                    </tr>
                </tbody>
            </table>
        </div>

        @if ($contacts->hasPages())
            <div class="pagination" id="paginationSection">
                @if ($contacts->onFirstPage())
                    <span class="disabled">Prev</span>
                @else
                    <a href="{{ $contacts->previousPageUrl() }}">Prev</a>
                @endif

                @for ($i = 1; $i <= $contacts->lastPage(); $i++)
                    @if ($i == $contacts->currentPage())
                        <span>{{ $i }}</span>
                    @else
                        <a href="{{ $contacts->url($i) }}">{{ $i }}</a>
                    @endif
                @endfor

                @if ($contacts->hasMorePages())
                    <a href="{{ $contacts->nextPageUrl() }}">Next</a>
                @else
                    <span class="disabled">Next</span>
                @endif
            </div>
        @endif

    </div>
</div>

<script>
/* ══════════════════════════════════════
   THEME
══════════════════════════════════════ */
function applyTheme(theme) {
    document.documentElement.setAttribute('data-theme', theme);
    document.getElementById('theme-icon').textContent  = theme === 'dark' ? '☀️' : '🌙';
    document.getElementById('theme-label').textContent = theme === 'dark' ? 'Light' : 'Dark';
    localStorage.setItem('theme', theme);
}
function toggleTheme() {
    applyTheme(document.documentElement.getAttribute('data-theme') === 'dark' ? 'light' : 'dark');
}
applyTheme(localStorage.getItem('theme') || 'dark');


/* ══════════════════════════════════════
   SEARCH HISTORY
══════════════════════════════════════ */
const HISTORY_KEY = 'contact_search_history';
const MAX_HISTORY = 10;

function getHistory()          { try { return JSON.parse(localStorage.getItem(HISTORY_KEY)) || []; } catch { return []; } }
function saveHistory(term)     {
    if (!term.trim()) return;
    let h = getHistory().filter(x => x.toLowerCase() !== term.toLowerCase());
    h.unshift(term.trim());
    localStorage.setItem(HISTORY_KEY, JSON.stringify(h.slice(0, MAX_HISTORY)));
}
function removeHistory(term)   { localStorage.setItem(HISTORY_KEY, JSON.stringify(getHistory().filter(x => x !== term))); }
function clearHistory()        { localStorage.removeItem(HISTORY_KEY); closeDropdown(); }


/* ══════════════════════════════════════
   HIGHLIGHT HELPER — bolds matched letters
══════════════════════════════════════ */
function highlightText(text, query) {
    if (!query) return escHtml(text);
    const escaped = query.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
    return escHtml(text).replace(new RegExp(`(${escaped})`, 'gi'), '<mark>$1</mark>');
}
function escHtml(s) {
    return s.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}


/* ══════════════════════════════════════
   LIVE SEARCH — filter table rows instantly
══════════════════════════════════════ */
const searchInput    = document.getElementById('searchInput');
const tableBody      = document.getElementById('tableBody');
const noResultsRow   = document.getElementById('noResultsRow');
const resultInfo     = document.getElementById('resultInfo');
const searchStatus   = document.getElementById('searchStatus');
const paginationSec  = document.getElementById('paginationSection');

// Store original cell text so we can restore after highlight
const allRows = Array.from(tableBody.querySelectorAll('tr[data-name]'));

allRows.forEach(row => {
    row._origName    = row.querySelector('.col-name').textContent;
    row._origEmail   = row.querySelector('.col-email').textContent;
    row._origMessage = row.querySelector('.col-message').textContent;
});

function liveFilter(q) {
    const query = q.trim().toLowerCase();
    let visible = 0;

    allRows.forEach(row => {
        const name    = row.dataset.name;
        const email   = row.dataset.email;
        const message = row.dataset.message;
        const match   = !query || name.includes(query) || email.includes(query) || message.includes(query);

        if (match) {
            row.classList.remove('hidden-row');
            visible++;
            if (query) {
                row.querySelector('.col-name').innerHTML    = highlightText(row._origName,    q.trim());
                row.querySelector('.col-email').innerHTML   = highlightText(row._origEmail,   q.trim());
                row.querySelector('.col-message').innerHTML = highlightText(row._origMessage, q.trim());
            } else {
                row.querySelector('.col-name').textContent    = row._origName;
                row.querySelector('.col-email').textContent   = row._origEmail;
                row.querySelector('.col-message').textContent = row._origMessage;
            }
        } else {
            row.classList.add('hidden-row');
        }
    });

    noResultsRow.classList.toggle('show', visible === 0 && query !== '');

    if (query) {
        resultInfo.style.display = 'block';
        resultInfo.innerHTML = `Showing <strong>${visible}</strong> of <strong>${allRows.length}</strong> contacts`;
        searchStatus.textContent = `${visible} found`;
        if (paginationSec) paginationSec.classList.add('hidden');
    } else {
        resultInfo.style.display = 'none';
        searchStatus.textContent = '';
        if (paginationSec) paginationSec.classList.remove('hidden');
    }
}


/* ══════════════════════════════════════
   SUGGESTIONS DROPDOWN
══════════════════════════════════════ */
const dropdown   = document.getElementById('suggestionsDropdown');
const searchForm = document.getElementById('searchForm');
let activeIdx    = -1;

function buildDropdown(query) {
    const q        = query.trim();
    const qLow     = q.toLowerCase();
    const history  = getHistory();

    // filter history by typed query
    const filtered = q
        ? history.filter(h => h.toLowerCase().includes(qLow))
        : history;

    if (filtered.length === 0) { closeDropdown(); return; }

    let html = `<div class="sug-section-label">🕐 Recent Searches</div>`;

    filtered.forEach((item, i) => {
        const display = highlightText(item, q);
        const safeVal = item.replace(/\\/g, '\\\\').replace(/'/g, "\\'");
        html += `
        <div class="sug-item" data-idx="${i}" data-val="${escHtml(item)}" onclick="selectSug('${safeVal}')">
            <span class="sug-ico">🔍</span>
            <span class="sug-text">${display}</span>
            <span class="sug-del" onclick="event.stopPropagation(); delSug('${safeVal}')">✕</span>
        </div>`;
    });

    html += `<div class="sug-divider"></div>
    <div class="sug-footer">
        <span>${filtered.length} recent</span>
        <span class="sug-clear" onclick="clearHistory()">Clear all</span>
    </div>`;

    dropdown.innerHTML = html;
    dropdown.classList.add('show');
    activeIdx = -1;
}

function closeDropdown() {
    dropdown.classList.remove('show');
    dropdown.innerHTML = '';
    activeIdx = -1;
}

function selectSug(val) {
    searchInput.value = val;
    closeDropdown();
    saveHistory(val);
    liveFilter(val);
}

function delSug(val) {
    removeHistory(val);
    buildDropdown(searchInput.value);
}


/* ══════════════════════════════════════
   KEYBOARD NAVIGATION IN DROPDOWN
══════════════════════════════════════ */
searchInput.addEventListener('keydown', e => {
    const items = dropdown.querySelectorAll('.sug-item');
    if (!items.length) return;

    if (e.key === 'ArrowDown') {
        e.preventDefault();
        activeIdx = Math.min(activeIdx + 1, items.length - 1);
    } else if (e.key === 'ArrowUp') {
        e.preventDefault();
        activeIdx = Math.max(activeIdx - 1, 0);
    } else if (e.key === 'Enter' && activeIdx >= 0) {
        e.preventDefault();
        selectSug(items[activeIdx].dataset.val);
        return;
    } else if (e.key === 'Escape') {
        closeDropdown(); return;
    } else { return; }

    items.forEach((el, i) => el.classList.toggle('active', i === activeIdx));
    if (activeIdx >= 0) searchInput.value = items[activeIdx].dataset.val;
});


/* ══════════════════════════════════════
   INPUT EVENTS
══════════════════════════════════════ */
let debounce = null;

searchInput.addEventListener('input', function () {
    const val = this.value;
    liveFilter(val);               // immediate table filter
    clearTimeout(debounce);
    debounce = setTimeout(() => buildDropdown(val), 200);   // dropdown after short delay
});

searchInput.addEventListener('focus', function () {
    buildDropdown(this.value);
});

document.addEventListener('click', e => {
    if (!e.target.closest('.search-input-wrap')) closeDropdown();
});

searchForm.addEventListener('submit', () => {
    const t = searchInput.value.trim();
    if (t) saveHistory(t);
});

// Run filter on page load if URL has ?search=...
if (searchInput.value) liveFilter(searchInput.value);
</script>
</body>
</html>