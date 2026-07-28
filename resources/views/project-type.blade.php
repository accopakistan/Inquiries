{{-- filepath: resources/views/project-type.blade.php --}}
@extends('layout.master')

@section('content')
<div class="page-header-row" style="width: 100% !important; display: flex !important; justify-content: space-between !important; align-items: center !important;">
    <div class="d-flex flex-column gap-1">
        <h2 class="display-font mb-0" style="font-weight: 800; letter-spacing: -0.03em;">Project Categories</h2>
        <p class="text-secondary mb-0">Manage different project type categories for inquiries sorting.</p>
    </div>
    
    <div class="d-flex flex-wrap gap-2 page-header-actions">
        <a href="{{ url('/add-project-type') }}" class="modern-btn btn-primary-modern flex-grow-1 flex-md-grow-0">
            <i class="bi bi-plus-circle"></i> Add Project Category
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success border-0 shadow-sm p-3 mb-4 d-flex align-items-center justify-content-between" role="alert" style="background-color: rgba(16, 185, 129, 0.1); color: var(--success-color); border-radius: var(--border-radius-md);">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-check-circle-fill"></i>
            <span>{{ session('success') }}</span>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="glass-card p-0 overflow-hidden">
    <div class="table-wrapper">
        <table class="modern-table">
            <thead>
                <tr>
                    <th style="width: 10%;"># ID</th>
                    <th>Category Title</th>
                    <th style="width: 25%; text-align: center;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($projectType as $item)
                    <tr>
                        <td><span class="fw-bold text-muted">#{{ $item->id }}</span></td>
                        <td><span class="fw-bold text-primary" style="font-size:1.05rem;">{{ $item->title }}</span></td>
                        <td>
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ url('/update-project-type', $item->id) }}" class="modern-btn btn-secondary-modern py-1 px-3" style="font-size:0.85rem; padding: 6px 15px !important;">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <button class="modern-btn btn-danger-modern py-1 px-3 opacity-50" style="font-size:0.85rem; padding: 6px 15px !important; cursor: not-allowed; border:none;" title="Deletion is disabled by system policy" disabled>
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center py-5 text-muted">No project categories found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
