{{-- filepath: resources/views/inquiries.blade.php --}}
@extends('layout.master')

@section('content')
<div class="page-header-row" style="width: 100% !important; display: flex !important; justify-content: space-between !important; align-items: center !important;">
    <div class="d-flex flex-column gap-1">
        <h2 class="display-font mb-0" style="font-weight: 800; letter-spacing: -0.03em;">Inquiries Directory</h2>
        <p class="text-secondary mb-0">Manage, sort, filter and export client inquiries.</p>
    </div>
    
    <div class="d-flex flex-wrap gap-2 page-header-actions">
        <a href="{{ url('/add-inquiry') }}" class="modern-btn btn-primary-modern flex-grow-1 flex-md-grow-0">
            <i class="bi bi-plus-circle"></i> Add Inquiry
        </a>
        <div class="dropdown flex-grow-1 flex-md-grow-0">
            <button class="modern-btn btn-secondary-modern dropdown-toggle w-100" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-download"></i> Export Data
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2 p-2" style="background-color: var(--bg-surface-solid); border-radius: var(--border-radius-md);">
                <li>
                    <a class="dropdown-item py-2" href="{{ url('/inquiries/export') }}">
                        <i class="bi bi-filetype-csv me-2 text-primary"></i> Export All (CSV)
                    </a>
                </li>
                <li>
                    <a class="dropdown-item py-2" href="{{ url('/inquiries/export-date') }}">
                        <i class="bi bi-calendar-range me-2 text-info"></i> Export Phone numbers by Date
                    </a>
                </li>
                <li>
                    <a class="dropdown-item py-2" href="{{ url('/inquiries/export-project-type') }}">
                        <i class="bi bi-funnel me-2 text-warning"></i> Export by Category (CSV)
                    </a>
                </li>
                <li>
                    <a class="dropdown-item py-2" href="{{ url('/inquiries/export-status') }}">
                        <i class="bi bi-file-earmark-excel me-2 text-success"></i> Export by Status (Excel)
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

<!-- Search & Filters -->
<div class="glass-card p-4 mb-4">
    <form id="inquiry-search-form" method="GET" action="{{ url('/inquiries') }}" class="search-bar-group">
        <div class="search-input-wrapper">
            <i class="bi bi-search search-input-icon"></i>
            <input type="text" id="inquiry-search-input" name="search" class="modern-input" placeholder="Search by name, phone, email, location, description, status..." value="{{ request('search') }}" autocomplete="off">
            <span class="search-spinner" id="inquiry-search-spinner"></span>
        </div>
        <button type="button" id="inquiry-search-clear" class="modern-btn btn-secondary-modern {{ request('search') ? '' : 'd-none' }}">
            <i class="bi bi-x-circle"></i> Clear
        </button>
    </form>
</div>

<!-- Alert notifications -->
@if(session('success'))
    <div class="alert alert-success border-0 shadow-sm p-3 mb-4 d-flex align-items-center justify-content-between" role="alert" style="background-color: rgba(16, 185, 129, 0.1); color: var(--success-color); border-radius: var(--border-radius-md);">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-check-circle-fill"></i>
            <span>{{ session('success') }}</span>
        </div>
        <button type="button" class="btn-close theme-aware-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div id="inquiries-results">
    @include('partials.inquiries-results')
</div>
@endsection

@push('scripts')
<script>
(function () {
    const form = document.getElementById('inquiry-search-form');
    const input = document.getElementById('inquiry-search-input');
    const spinner = document.getElementById('inquiry-search-spinner');
    const clearBtn = document.getElementById('inquiry-search-clear');
    const results = document.getElementById('inquiries-results');
    const baseUrl = form.getAttribute('action');

    let debounceTimer = null;
    let activeRequest = null;

    function setLoading(isLoading) {
        spinner.classList.toggle('active', isLoading);
    }

    function fetchResults(url, pushState) {
        setLoading(true);

        if (activeRequest) {
            activeRequest.abort();
        }
        const controller = new AbortController();
        activeRequest = controller;

        fetch(url, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            signal: controller.signal,
        })
            .then((response) => response.text())
            .then((html) => {
                results.innerHTML = html;
                if (pushState) {
                    window.history.replaceState({}, '', url);
                }
            })
            .catch((err) => {
                if (err.name !== 'AbortError') {
                    console.error('Live search failed:', err);
                }
            })
            .finally(() => {
                setLoading(false);
                activeRequest = null;
            });
    }

    function buildUrl(term) {
        const params = new URLSearchParams();
        if (term) {
            params.set('search', term);
        }
        const qs = params.toString();
        return qs ? `${baseUrl}?${qs}` : baseUrl;
    }

    input.addEventListener('input', function () {
        const term = input.value.trim();
        clearBtn.classList.toggle('d-none', term === '');

        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(function () {
            fetchResults(buildUrl(term), true);
        }, 350);
    });

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        clearTimeout(debounceTimer);
        fetchResults(buildUrl(input.value.trim()), true);
    });

    clearBtn.addEventListener('click', function () {
        input.value = '';
        clearBtn.classList.add('d-none');
        clearTimeout(debounceTimer);
        fetchResults(baseUrl, true);
        input.focus();
    });

    // Intercept pagination links inside the live results so paging
    // through search matches doesn't force a full page reload either.
    const inquiriesPath = new URL(baseUrl, window.location.href).pathname;
    results.addEventListener('click', function (e) {
        const link = e.target.closest('a');
        if (!link || !link.href) {
            return;
        }
        if (link.origin !== window.location.origin || link.pathname !== inquiriesPath) {
            return;
        }
        e.preventDefault();
        fetchResults(link.href, true);
        results.scrollIntoView({ behavior: 'smooth', block: 'start' });
    });
})();
</script>
@endpush
